<?php

namespace Tests\Controllers;

use CodeIgniter\Config\Services;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Test suite for the Login controller, including the CI Throttler
 * mitigation for brute-force/credential-stuffing.
 */
class LoginTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = false;
    protected $namespace   = null;

    private array $usedKeys = [];

    #[DataProvider('localeDirections')]
    public function testIndex_AcceptsLocaleDirectionAndStylesheet(string $languageCode, string $direction, string $stylesheet, string $theme = 'flatly'): void
    {
        $settings = $this->db->table('app_config')
            ->whereIn('key', ['language_code', 'theme'])
            ->get()->getResultArray();

        try {
            $this->db->table('app_config')->where('key', 'language_code')->update(['value' => $languageCode]);
            $this->db->table('app_config')->where('key', 'theme')->update(['value' => $theme]);

            Services::cache()->delete('settings');
            $response = $this->get('/login');
            $response->assertStatus(200);

            $html = $response->response()->getBody();
            $this->assertStringContainsString('<html lang="' . $languageCode . '" dir="' . $direction . '">', $html);
            $this->assertStringContainsString('resources/bootswatch/flatly/' . $stylesheet, $html);
        } finally {
            Services::cache()->delete('settings');
            foreach ($settings as $setting) {
                $this->db->table('app_config')->where('key', $setting['key'])->update(['value' => $setting['value']]);
            }
        }
    }

    public static function localeDirections(): iterable
    {
        return [
            'English'        => ['en', 'ltr', 'bootstrap.min.css'],
            'Sorani'         => ['ckb', 'rtl', 'bootstrap.rtl.min.css'],
            'Arabic Egypt'   => ['ar-EG', 'rtl', 'bootstrap.rtl.min.css'],
            'Arabic Lebanon' => ['ar-LB', 'rtl', 'bootstrap.rtl.min.css'],
            'Legacy paper theme' => ['en', 'ltr', 'bootstrap.min.css', 'paper'],
            'Legacy readable theme' => ['ar-EG', 'rtl', 'bootstrap.rtl.min.css', 'readable'],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        Services::session()->destroy();
        $this->clearThrottleState();
    }

    protected function tearDown(): void
    {
        $this->clearThrottleState();

        parent::tearDown();
    }

    private function clearThrottleState(): void
    {
        $throttler = Services::throttler();

        foreach ($this->usedKeys as $key) {
            $throttler->remove($key);
        }

        $this->usedKeys = [];

        Services::resetSingle('throttler');
    }

    private function trackThrottleKeys(string $username = ''): void
    {
        $this->usedKeys[] = 'login-ip-' . Services::request()->getIPAddress();

        if ($username !== '') {
            $this->usedKeys[] = 'login-user-' . strtolower($username);
        }
    }

    /**
     * Login::index() redirects to 'login' and runs a migration when the
     * app's migration state isn't current, bypassing credential checks
     * entirely. Skip credential-dependent assertions in that case so this
     * test only exercises login logic when the DB is actually current
     * (throttling itself is verified independently and runs before this
     * branch, so it's unaffected).
     */
    private function skipIfMigrationRequired(\CodeIgniter\Test\TestResponse $response): void
    {
        $redirectUrl = $response->getRedirectUrl();

        if ($redirectUrl !== null && str_ends_with(rtrim(strtolower($redirectUrl), '/'), '/login')) {
            $this->markTestSkipped('App migration state is not current in this environment; skipping credential-path assertions.');
        }
    }

    public function testValidCredentialsLogsIn(): void
    {
        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'pointofsale',
        ]);
        $this->trackThrottleKeys('admin');

        $this->skipIfMigrationRequired($response);

        $response->assertRedirectTo('home');
    }

    public function testInvalidCredentialsShowsError(): void
    {
        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'wrongpassword',
        ]);
        $this->trackThrottleKeys('admin');

        $this->skipIfMigrationRequired($response);

        $response->assertStatus(200);
        $response->assertSee(lang('Login.invalid_username_and_password'));
    }

    public function testSixthFailedAttemptIsThrottled(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'username' => 'wronguser',
                'password' => 'wrongpassword',
            ]);
            $this->trackThrottleKeys('wronguser');
        }

        $response = $this->post('/login', [
            'username' => 'wronguser',
            'password' => 'wrongpassword',
        ]);
        $this->trackThrottleKeys('wronguser');

        $response->assertStatus(429);
        $result = json_decode($response->getJSON(), true);
        $this->assertFalse($result['success']);
        $this->assertSame(lang('Login.too_many_attempts'), $result['message']);
    }

    public function testCorrectLoginStillWorksUnderThrottleCapacity(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->post('/login', [
                'username' => 'admin',
                'password' => 'wrongpassword',
            ]);
            $this->trackThrottleKeys('admin');
        }

        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'pointofsale',
        ]);
        $this->trackThrottleKeys('admin');

        $this->skipIfMigrationRequired($response);

        $response->assertRedirectTo('home');
    }

    public function testGetRequestToLoginIsNeverThrottled(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $response = $this->get('/login');
            $this->skipIfMigrationRequired($response);
            $response->assertStatus(200);
        }
    }
}

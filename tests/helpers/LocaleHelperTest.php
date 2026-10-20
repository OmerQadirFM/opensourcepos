<?php

use App\Models\Employee;
use CodeIgniter\Config\Factories;
use CodeIgniter\Test\CIUnitTestCase;
use Config\OSPOS;
use PHPUnit\Framework\Attributes\DataProvider;

class LocaleHelperTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        require_once __DIR__ . '/../../app/Helpers/locale_helper.php';

        $config           = new OSPOS();
        $config->settings = ['dateformat' => 'Y-m-d'];
        Factories::injectMock('config', OSPOS::class, $config);
    }

    public function testValidDateReturnsTrue(): void
    {
        $this->assertTrue(isValidDate('2024-06-10'));
    }

    public function testInvalidDateFormatReturnsFalse(): void
    {
        $this->assertFalse(isValidDate('10/06/2024'));
    }

    public function testImpossibleDateReturnsFalse(): void
    {
        $this->assertFalse(isValidDate('2024-13-01'));
    }

    public function testPhpDateOverflowReturnsFalse(): void
    {
        // PHP silently overflows Feb 30 → Mar 1; the format()===candidate check catches this
        $this->assertFalse(isValidDate('2024-02-30'));
    }

    public function testEmptyStringReturnsFalse(): void
    {
        $this->assertFalse(isValidDate(''));
    }

    public function testLeapDayValidReturnsTrue(): void
    {
        $this->assertTrue(isValidDate('2024-02-29'));
    }

    public function testLeapDayInvalidYearReturnsFalse(): void
    {
        $this->assertFalse(isValidDate('2023-02-29'));
    }

    public function testPartialDateReturnsFalse(): void
    {
        $this->assertFalse(isValidDate('2024-06'));
    }

    #[DataProvider('languageDirections')]
    public function testCurrentLanguageDirection_AcceptsLanguageAndRegionalCodes(string $languageCode, string $direction): void
    {
        $this->assertSame($direction, currentLanguageDirection($languageCode));
    }

    public static function languageDirections(): iterable
    {
        return [
            'Sorani'                 => ['ckb', 'rtl'],
            'regional Sorani'        => ['ckb-IQ', 'rtl'],
            'Arabic'                 => ['ar', 'rtl'],
            'Egyptian Arabic'        => ['ar-EG', 'rtl'],
            'Lebanese Arabic'        => ['ar-LB', 'rtl'],
            'underscore locale'      => ['ar_IQ', 'rtl'],
            'uppercase locale'       => ['CKB', 'rtl'],
            'Persian'                => ['fa', 'rtl'],
            'Hebrew'                 => ['he', 'rtl'],
            'Urdu'                   => ['ur', 'rtl'],
            'English'                => ['en', 'ltr'],
            'British English'        => ['en-GB', 'ltr'],
            'Kurdish without script' => ['ku', 'ltr'],
            'unknown language'       => ['unknown', 'ltr'],
            'empty language'         => ['', 'ltr'],
        ];
    }

    public function testCurrentLanguageDirection_AcceptsSystemLanguageBeforeLogin(): void
    {
        $config           = new OSPOS();
        $config->settings = ['language_code' => 'ckb'];
        Factories::injectMock('config', OSPOS::class, $config);

        $employee = $this->getMockBuilder(Employee::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['is_logged_in'])
            ->getMock();
        $employee->method('is_logged_in')->willReturn(false);
        Factories::injectMock('models', Employee::class, $employee);

        $this->assertSame('rtl', currentLanguageDirection());
    }

    #[DataProvider('employeeLanguageDirections')]
    public function testCurrentLanguageDirection_AcceptsEmployeeLanguageOverride(string $systemLanguage, string $employeeLanguage, string $direction): void
    {
        $config           = new OSPOS();
        $config->settings = ['language_code' => $systemLanguage];
        Factories::injectMock('config', OSPOS::class, $config);

        $employee = $this->getMockBuilder(Employee::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['is_logged_in', 'get_logged_in_employee_info'])
            ->getMock();
        $employee->method('is_logged_in')->willReturn(true);
        $employee->method('get_logged_in_employee_info')->willReturn((object) ['language_code' => $employeeLanguage]);
        Factories::injectMock('models', Employee::class, $employee);

        $this->assertSame($direction, currentLanguageDirection());
    }

    public static function employeeLanguageDirections(): iterable
    {
        return [
            'Arabic employee in English store' => ['en', 'ar-EG', 'rtl'],
            'English employee in Sorani store' => ['ckb', 'en', 'ltr'],
            'employee inherits Sorani store'   => ['ckb', '', 'rtl'],
        ];
    }
}

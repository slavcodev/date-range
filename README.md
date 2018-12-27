# Date Range

[![Build Status][ico-travis]][link-travis]
[![Code Coverage][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![GitHub issues][ico-issues]][link-issues]

[![Software License][ico-license]][link-license]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![PHP Version][ico-php-version]][link-github]

Implementation of the **Date Range** missing in PHP.

## Install

Using [Composer](https://getcomposer.org)

```bash
composer require zeeproject/date-range
```

## Usage

### DateRange - value object

Instantiating value object and accessing properties:

~~~php
$range = new DateRange(new DateTime('-1 day'), new DateTime('+1 day'));
// Checking if range has start date
$range->hasStartDate();
// Accessing range start date
$range->getStartDate()->format('c');
// Checking if range has end date
$range->hasEndDate();
// Accessing range end date
$range->getEndDate()->format('c');
// Checking if range is finite
$range->isFinite();
// Checking if range already started
$range->isStarted();
// Checking if range already ended
$range->isEnded();
// Checking if range started on specific date
$range->isStartedOn(new DateTime());
// Checking if range ended on specific date
$range->isEndedOn(new DateTime());
// Accessing range duration in seconds
$range->getTimestampInterval();
// Accessing range interval
$range->getDateInterval()->format('%s');
// Printing
echo $range;
// Representing as JSON
json_encode($range);
~~~

Iterating over the range:

~~~php
$range = new DateRange(new DateTime('-1 day'), new DateTime('+1 day'));

foreach ($range->getDatePeriod(new DateInterval('P1D')) as $date) {
    echo $date->format('Y-m-d');
}
~~~

Splitting range into smaller ranges:

~~~php
$range = new DateRange(new DateTime('-1 day'), new DateTime('+1 day'));

foreach ($range->split(new DateInterval('P1D')) as $range) {
    echo $range;
}
~~~

Date range is immutable, any changes resulting to new object:

~~~php
$initial = new DateRange(new DateTime('-1 day'), new DateTime('+1 day'));
$actual = $initial->setStartDate(new DateTime('now'));
if ($initial === $actual) {
    throw new LogicException('Oh, ah');
}
~~~

### DateRangeProvider - the date ranges builder.

Using builder to create new range with specific rules:

~~~php
class RangeForYear implements DateRangeProvider
{
    /**
     * @var int
     */
    private $year;

    /**
     * @param int $year
     */
    public function __construct(int $year)
    {
        $this->year = $year;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateRange(): DateRangeInterface
    {
        return new DateRange(
            new DateTimeImmutable(DateTimeImmutable::createFromFormat('c', "{$this->year}-01-01T00:00:00Z")),
            new DateTimeImmutable(DateTimeImmutable::createFromFormat('c', "{$this->year}-12-31T23:59:59Z"))
        );
    }
}
~~~

Your classes might depend on range provider instead of `DateRange`,
useful when predefined ranges are more meaningful than range interface:

~~~php
class ReportCalculator
{
    public function calculate(DateRangeProvider $provider)
    {
        echo $provider->getDateRange();
    }
}

$calculator->calculate(new RangeForYear(2017));
$calculator->calculate(new RangeForQuarter(2017));
$calculator->calculate(new RangeForMonth(2017));
~~~

Even your class might require concrete range contract:

~~~php
class ReportCalculator
{
    public function calculate(FiniteDateRangeProvider $provider)
    {
        echo $provider->getDateRange();
    }
}
~~~

## Testing

```bash
phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE OF CONDUCT](CODE_OF_CONDUCT.md) for more details.

[ico-version]: https://img.shields.io/packagist/v/zeeproject/date-range.svg?style=for-the-badge&label=Latest
[ico-php-version]: https://img.shields.io/packagist/php-v/zeeproject/date-range.svg?style=for-the-badge
[ico-license]: https://img.shields.io/badge/License-BSD%202--Clause-blue.svg?style=for-the-badge
[ico-issues]: https://img.shields.io/github/issues/zee/date-range.svg?style=for-the-badge&logo=github
[ico-travis]: https://img.shields.io/travis/zee/date-range.svg?style=for-the-badge&logo=travis
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/zee/date-range.svg?style=for-the-badge&logo=scrutinizer
[ico-code-quality]: https://img.shields.io/scrutinizer/g/zee/date-range.svg?style=for-the-badge&logo=scrutinizer

[link-packagist]: https://packagist.org/packages/zeeproject/date-range
[link-github]: https://github.com/zee/date-range
[link-issues]: https://github.com/zee/date-range/issues
[link-license]: LICENSE
[link-travis]: https://travis-ci.org/zee/date-range
[link-scrutinizer]: https://scrutinizer-ci.com/g/zee/date-range/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/zee/date-range

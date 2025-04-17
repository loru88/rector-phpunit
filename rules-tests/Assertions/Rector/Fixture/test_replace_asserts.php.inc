<?php

namespace Rector\PHPUnit\Tests\Assertions\Rector\Fixture;

use PHPUnit\Framework\Assert;

class SomeClass
{
    function somemethod(): void
    {
        \Webmozart\Assert\Assert::assertTrue(true);
        Assert::assertFalse(true);
        Assert::assertEquals('2', 1);
    }
}
?>
-----
<?php

namespace Rector\PHPUnit\Tests\Assertions\Rector\Fixture;

use Webmozart\Assert\Assert;

class SomeClass
{
    function somemethod(): void
    {
        Assert::true(true);
        Assert::false(true);
        Assert::eq('2', 1);
    }
}
?>

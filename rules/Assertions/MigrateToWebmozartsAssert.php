<?php

declare(strict_types=1);

namespace Rector\PHPUnit\Assertions;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name\FullyQualified;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see PreferPHPUnitSelfCallRector
 * @see AssertFuncCallToPHPUnitAssertRector
 */
class MigrateToWebmozartsAssert extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Migrate the PHPUnit Assert to Webmozarts/Asserts', [
                new CodeSample(
                    'Assert::assertTrue(true);',
                    'Webmozart\Assert\Assert::true(true);'
                )
            ]
        );
    }

    public function getNodeTypes(): array
    {
        return [StaticCall::class];
    }

    public function refactor(Node $node)
    {

        if (!$node instanceof StaticCall) {
            return null;
        }

        $methodName = $node->name->name;
        if (! str_starts_with($methodName, 'assert')) {
            return null;
        }

        $mapping = [
            'assertTrue' => 'true',
            'assertFalse' => 'false',
            'assertNull' => 'null',
            'assertNotNull' => 'null',
            'assertEquals' => 'eq',
        ];

        $newMethodName = $mapping[$methodName] ?? null;
        if ($newMethodName === null) {
            return null;
        }

        $assertFullyQualified = new FullyQualified('Webmozart\Assert\Assert');
        return new StaticCall($assertFullyQualified, $newMethodName, $node->args);

    }
}

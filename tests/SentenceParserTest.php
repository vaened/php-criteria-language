<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Tests;

use DateTimeImmutable;
use Vaened\CriteriaCore\Keyword\FilterOperator;
use Vaened\CriteriaCore\Statement;
use Vaened\CriteriaCore\Statements;
use Vaened\CriteriaLanguage\SentenceParser;
use Vaened\CriteriaLanguage\Specification;

final class SentenceParserTest extends TestCase
{
    public function test_analyzes_and_understands_the_sentences_for_a_textualized_person(): void
    {
        $parser = new SentenceParser(
            Specification::date('birthdate')->named('fecha de nacimiento'),
            Specification::number('history')->named('historia'),
            Specification::char('document')->named('documento'),
            Specification::text('name')->named('nombre'),
        );

        $statements = $parser->parse(
            '
            [historia]=1 & 
            [nombre]=%enea% &
            [documento]=![12345678, 87654321] & 
            [fecha de nacimiento]={1996, 200006}
            '
        );

        $this->assertEquals(
            Statements::of([
                Statement::that('history', FilterOperator::Equal, 1),
                Statement::that('name', FilterOperator::Contains, 'enea'),
                Statement::that('document', FilterOperator::NotIn, ['12345678', '87654321']),
                Statement::that('birthdate', FilterOperator::Between, [
                    new DateTimeImmutable('1996-01-01'),
                    new DateTimeImmutable('2000-06-30T23:59:59.999999'),
                ]),
            ]),
            $statements
        );
    }

    public function test_analyzes_and_understands_the_statements_for_a_textualized_repository(): void
    {
        $parser = new SentenceParser(
            Specification::text('author'),
            Specification::date('created'),
            Specification::char('languages'),
            Specification::char('visibility'),
        );

        $statements = $parser->parse(
            '
            [author]=enea% & 
            [created]={2020, 202306} & 
            [languages]=[PHP, JAVA]&
            [visibility]=![private, archived] &
            '
        );

        $this->assertEquals(
            Statements::of([
                Statement::that('author', FilterOperator::StartsWith, 'enea'),
                Statement::that('created', FilterOperator::Between, [
                    new DateTimeImmutable('2020-01-01'),
                    new DateTimeImmutable('2023-06-30T23:59:59.999999')
                ]),
                Statement::that('languages', FilterOperator::In, ['PHP', 'JAVA']),
                Statement::that('visibility', FilterOperator::NotIn, ['private', 'archived']),
            ]),
            $statements
        );
    }
}

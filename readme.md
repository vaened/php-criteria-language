# Php Criteria Language

Build criteria based on a string of characters

```bash
composer require vaened/php-criteria-language
```

**this**

```
[author]=enea% & 
[created]={2020, 202306} & 
[languages]=[PHP, JAVA]&
[visibility]=![private, archived] &
```

**becomes**

```php
Statements::of([
    Statement::that('author', FilterOperator::StartsWith, 'enea'),
    Statement::that('created', FilterOperator::Between, [
        new DateTimeImmutable('2020-01-01'),
        new DateTimeImmutable('2023-06-30T23:59:59.999999')
    ]),
    Statement::that('languages', FilterOperator::In, ['PHP', 'JAVA']),
    Statement::that('visibility', FilterOperator::NotIn, ['private', 'archived']),
]);
```
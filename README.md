# README

## Using Symfony MakerBundle

Install
```
$ composer require --dev symfony/maker-bundle
```

Create entity
```
$ php bin/console make:entity
```

Create new class
```
php bin/console make:controller BrandNewController

created: src/Controller/BrandNewController.php
created: templates/brandnew/index.html.twig
```

OR magically create an entire CRUD from a Doctrine entity
```
$ php bin/console make:crud Product

created: src/Controller/ProductController.php
created: src/Form/ProductType.php
created: templates/product/_delete_form.html.twig
created: templates/product/_form.html.twig
created: templates/product/edit.html.twig
created: templates/product/index.html.twig
created: templates/product/new.html.twig
created: templates/product/show.html.twig
```

When creating a new Doctrine entity run a migration:
```
$ php bin/console make:migration

$ php bin/console doctrine:migrations:migrate
```
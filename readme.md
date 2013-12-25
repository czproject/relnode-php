RelNode-PHP
-----------

Helper class.

``` php
<?php
    $root = new Cz\RelNode;
    $root->addChild('sub/sub1/sub2/sub3', 'sub value');
    $root->addChild('sub/sub1/sub2/sub3/sub4', 'sub value 2');
    $root->addChild('sub/sub1/sub5', 'sub value 3');

    /**
    Structure:

    $root
    └── sub
        └── sub1
            ├── sub2
            │   └── sub3 (sub value) [first filled, one of the nearest]
            │       └── sub4 (sub value 2)
            │
            └── sub5 (sub value 3) [one of the nearest]
    */

    $node = $root->getFirstFilled();
    echo $node->value; // 'sub value'

    $nodes = $root->getNearestChildren();

    foreach($nodes as $node) {
        echo $node->value;

        // Prints:
        // 'sub value'
        // 'sub value 3'
    }
```

------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, http://janpecha.iunas.cz/


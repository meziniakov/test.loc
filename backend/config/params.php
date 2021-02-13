<?php
use yii\web\JsExpression;

return [
  'url' => 'https://ivanovo.spravka.city/restorany-kafe-zavedeniya',
  'uri' => 'https://ivanovo.spravka.city',
  'mainTag' => '.category-card',
  'title' => 'h1',
  'description' => 'h2.description',
  'region' => '.region',
  'street' => '.street',
  'description-text' => '.description-text',
  'afterTitle' => 'div.description-text',
  'sku' => 'div.article',
  'price' => 'span.new',
  'attr-image' => 'src',
  'editorjs-widget/plugins' => [
      'header' => [
          'repository' => 'editorjs/header',
          'class' => new JsExpression('Header'),
          'inlineToolbar' => true,
          'config' => ['placeholder' => 'Header', 'levels' => [2, 3, 4, 5]],
          'shortcut' => 'CMD+SHIFT+H'
      ],
      'paragraph' => [
          'repository' => 'editorjs/paragraph',
          'class' => new JsExpression('Paragraph'),
          'inlineToolbar' => true,
      ],
      'image' => [
          'repository' => 'editorjs/image',
          'class' => new JsExpression('ImageTool'),
          'config' => [
              'field' => 'image',
              'additionalRequestHeaders' => [],
              'endpoints' => [
              ]
          ]
      ],
      'list' => [
          'repository' => 'editorjs/list',
          'class' => new JsExpression('List'),
          'inlineToolbar' => true,
          'shortcut' => 'CMD+SHIFT+L'
      ],
      'table' => [
          'repository' => 'editorjs/table',
          'class' => new JsExpression('Table'),
          'inlineToolbar' => true,
          'shortcut' => 'CMD+ALT+T'
      ],
      'quote' => [
          'repository' => 'editorjs/quote',
          'class' => new JsExpression('Quote'),
          'inlineToolbar' => true,
          'config' => ['quotePlaceholder' => 'Quote', 'captionPlaceholder' => 'Author'],
          'shortcut' => 'CMD+SHIFT+O'
      ],
      'warning' => [
          'repository' => 'editorjs/warning',
          'class' => new JsExpression('Warning'),
          'inlineToolbar' => true,
          'config' => ['titlePlaceholder' => 'Title', 'messagePlaceholder' => 'Description'],
          'shortcut' => 'CMD+SHIFT+W'
      ],
      'code' => [
          'repository' => 'editorjs/code',
          'class' => new JsExpression('CodeTool'),
          'shortcut' => 'CMD+SHIFT+C'
      ],
      'embed' => [
          'repository' => 'editorjs/embed',
          'class' => new JsExpression('Embed')
      ],
      'delimiter' => [
          'repository' => 'editorjs/delimiter',
          'class' => new JsExpression('Delimiter')
      ],
      'inline-code' => [
          'repository' => 'editorjs/inline-code',
          'class' => new JsExpression('InlineCode'),
          'shortcut' => 'CMD+SHIFT+C'
      ],
      'сarousel' => [
          'repository' => '@backend/web/static/carousel/bundle.js',
          'class' => new JsExpression('Carousel'),
          'config' => [
            'additionalRequestHeaders' => [],
            'endpoints' => [
            ]
          ]
      ]
  ],
];

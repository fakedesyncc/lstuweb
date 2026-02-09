<?php

/**
 * Простой генератор документации из PHPDoc комментариев
 * 
 * @author fakedesyncc
 */

$outputDir = __DIR__ . '/docs/html';
$srcDir = __DIR__ . '/src';

if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}

$classes = [];
$functions = [];

function scanDirectory(string $dir, array &$classes, array &$functions): void
{
    $files = glob($dir . '/*.php');
    
    foreach ($files as $file) {
        $content = file_get_contents($file);
        if ($content === false) {
            continue;
        }
        
        if (preg_match('/namespace\s+([^;]+);/', $content, $namespaceMatch)) {
            $namespace = $namespaceMatch[1];
        } else {
            $namespace = '';
        }
        
        if (preg_match('/class\s+(\w+)/', $content, $classMatch)) {
            $className = $classMatch[1];
            $fullName = $namespace ? $namespace . '\\' . $className : $className;
            
            preg_match('/\/\*\*.*?\*\/.*?class\s+\w+/s', $content, $docMatch);
            $doc = $docMatch[0] ?? '';
            
            preg_match('/@author\s+([^\n]+)/', $doc, $authorMatch);
            $author = $authorMatch[1] ?? '';
            
            preg_match_all('/public\s+(?:static\s+)?function\s+(\w+)\s*\([^)]*\)\s*:\s*(\w+)/', $content, $methods);
            
            $classes[] = [
                'name' => $fullName,
                'shortName' => $className,
                'namespace' => $namespace,
                'author' => trim($author),
                'file' => str_replace(__DIR__ . '/', '', $file),
                'methods' => $methods[1] ?? []
            ];
        }
    }
    
    $subdirs = glob($dir . '/*', GLOB_ONLYDIR);
    foreach ($subdirs as $subdir) {
        scanDirectory($subdir, $classes, $functions);
    }
}

scanDirectory($srcDir, $classes, $functions);

$html = '<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - Автосалон</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 10px;
        }
        .class {
            background: white;
            margin: 20px 0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .class-name {
            font-size: 24px;
            color: #4CAF50;
            margin-bottom: 10px;
        }
        .namespace {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .author {
            color: #999;
            font-size: 12px;
            margin-top: 10px;
        }
        .methods {
            margin-top: 15px;
        }
        .method {
            padding: 8px;
            background: #f9f9f9;
            margin: 5px 0;
            border-left: 3px solid #4CAF50;
        }
        .file {
            color: #666;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1>API Documentation - Автосалон</h1>
    <p>Автоматически сгенерированная документация из PHPDoc комментариев</p>
';

foreach ($classes as $class) {
    $html .= '
    <div class="class">
        <div class="class-name">' . htmlspecialchars($class['shortName']) . '</div>
        <div class="namespace">' . htmlspecialchars($class['namespace']) . '</div>
        <div class="file">Файл: ' . htmlspecialchars($class['file']) . '</div>';
    
    if ($class['author']) {
        $html .= '<div class="author">Автор: ' . htmlspecialchars($class['author']) . '</div>';
    }
    
    if (!empty($class['methods'])) {
        $html .= '<div class="methods"><strong>Методы:</strong>';
        foreach ($class['methods'] as $method) {
            $html .= '<div class="method">' . htmlspecialchars($method) . '()</div>';
        }
        $html .= '</div>';
    }
    
    $html .= '</div>';
}

$html .= '
    <footer style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; text-align: center;">
        <p>Сгенерировано: ' . date('Y-m-d H:i:s') . '</p>
        <p>Автор: fakedesyncc</p>
    </footer>
</body>
</html>';

file_put_contents($outputDir . '/index.html', $html);

echo "✅ Документация сгенерирована в: $outputDir/index.html\n";
echo "📊 Найдено классов: " . count($classes) . "\n";

<?php

namespace App\Views;

/**
 * @author fakedesyncc
 */
class View
{
    private string $basePath;

    public function __construct()
    {
        $this->basePath = __DIR__ . '/../../views';
    }

    public function render(string $template, array $data = []): void
    {
        extract($data);
        
        $templatePath = $this->basePath . '/' . $template . '.php';
        
        if (!file_exists($templatePath)) {
            throw new \RuntimeException("Template not found: {$template}");
        }
        
        ob_start();
        include $templatePath;
        $content = ob_get_clean();
        
        $title = $title ?? 'Автосалон';
        // Используем общий layout из project (без дублирования заголовков)
        include __DIR__ . '/../../../project/public/layout.php';
    }
}

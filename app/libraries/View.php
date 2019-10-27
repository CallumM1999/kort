<?php

class View {
    public static function render($view, $data = []) {
        $path = self::buildDirPath($view);

        // Search for view, ignoring the extension
        $search = glob ($path . ".*");

        $fileExists = sizeof($search) > 0;
        if (!$fileExists) throw new Exception('Template not found');

        // Get file info
        $file = pathinfo($search[0]);

        $isTemplate = substr($file['filename'], -4) === '.tmp';

        // Get path with correct file extension
        $path = $file['dirname'] . '/' . $file['basename'];

        // Render view
        if ($isTemplate) {
            self::templateView($path, $data);
        } else {
            self::normalView($path, $data);
        }

        exit();
    }

    private static function buildDirPath($view) {
        // Determine is view loaded from Route::view() or controller
        // With a controller, the file would be stored in /controller/filename
        // instead of /filename

        $fromView = debug_backtrace()[2]['class'] === 'Route';
        $fromController = debug_backtrace()[3]['function'] === 'loadController';

        $path = '';

        if ($fromView) {
            $path = APPROOT . '/views/' . $view;       
        } else if ($fromController) {
            // Controller name

            $cname = debug_backtrace()[2]['class'];
            // Remove namespace
            $cname = explode("\\", $cname)[1];
            $path = APPROOT . '/views/' . $cname . '/' . $view;
        } else {
            $path = APPROOT . '/views/' . $view; 
        }

        return $path;
    }

    private static function normalView($path, $data) {
        require_once $path;
    }

    private static function templateView($path, $data) {
        $template = new Template($path);        
        $template->render($data);
    }
}
<?php

function renderTemplate($template, $data = array())
{
    if (file_exists('templates/' . $template . '.php')) {
        ob_start();
        extract($data);
        require 'templates/' . $template . '.php';
        return ob_get_clean();
    }
}
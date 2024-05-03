<?php

declare(strict_types=1);

# Rendering HTML templates after calling at index.php
/**
 * @param string $template
 * @param array $data 
 * @return void
 */
function render_template(string $template, array $data = [])
{
  extract($data);
  require "assets/templates/$template.php";
}

<?php

function css_url($nom) 
{
  	return base_url() . 'assets/css/'. $nom . '.css';
}

function fontcss_url($nom) 
{
  	return base_url() . 'assets/font/css/'. $nom . '.css';
}

function js_url($nom) 
{
    	return base_url() . 'assets/js/'. $nom . '.js';
}

function img_url($nom) 
{
    	return base_url() . 'assets/images/'. $nom;
}

function img($nom, $alt = '') 
{
  	return '<img src="'. img_url($nom). '" alt="'.$alt.'">';
}

?>
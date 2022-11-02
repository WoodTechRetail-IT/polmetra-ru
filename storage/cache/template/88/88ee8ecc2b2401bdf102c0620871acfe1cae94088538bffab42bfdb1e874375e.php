<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* default/template/extension/module/image_option.twig */
class __TwigTemplate_dc088b7e4a17b2235c7d81d7ecff9ee9e1ff327f8fee542ca67e8a4337a0a090 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<script type=\"text/javascript\"><!--
var product_options_images = ";
        // line 2
        echo ($context["product_options_images"] ?? null);
        echo ";
var images_product_options_values = ";
        // line 3
        echo ($context["images_product_options_values"] ?? null);
        echo ";
\$(document).ready(function() {

  \$(\"div[id^='input-option'] input[type='checkbox'], div[id^='input-option'] input[type='radio'], select[id^='input-option']\").change(function() {

    if (\$(this).is('select') || (\$(this).is('input') && \$(this).is(':checked'))) {
    
      // all checked options
      var checked = \$(\"div[id^='input-option'] input:checked, select[id^='input-option'] option:selected\");

      // array with checked ids
      var checked_ids = [];
      // fill array
      checked.each(function(i) {
        checked_ids[i] = \$(this).val();
      });
      //console.log(checked_ids);          
      
      var product_option_value_id = \$(this).val();

      if (product_options_images[product_option_value_id] !== undefined ) {
      
        \$.each(product_options_images[product_option_value_id], function(index, product_options_images_image){

          //check if all options for this image checked 
          var all_options_checked = true;

          \$.each(images_product_options_values[product_options_images_image['image']], function(index2, product_option_value_id){
            if (checked_ids.indexOf(product_option_value_id) == -1) {
              all_options_checked = false;
            }
          });

          if (all_options_checked) {
            var image = product_options_images_image['image_thumb'];
            var image_popup = product_options_images_image['image_popup'];
            ";
        // line 39
        if (twig_test_empty((($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 = ($context["image_option_options"] ?? null)) && is_array($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4) || $__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 instanceof ArrayAccess ? ($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4["javascript"] ?? null) : null))) {
            echo " 
              \$('.thumbnails .thumbnail img').not(\".image-additional .thumbnail img\").attr('src', image);
              \$('.thumbnails a.thumbnail').not(\".image-additional a.thumbnail\").attr('href', image_popup);                
            ";
        } else {
            // line 42
            echo " 
              ";
            // line 43
            echo (($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144 = ($context["image_option_options"] ?? null)) && is_array($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144) || $__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144 instanceof ArrayAccess ? ($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144["javascript"] ?? null) : null);
            echo "
            ";
        }
        // line 44
        echo "             
          }
        });
      }    
    }
  });    
});
//--></script>";
    }

    public function getTemplateName()
    {
        return "default/template/extension/module/image_option.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  98 => 44,  93 => 43,  90 => 42,  83 => 39,  44 => 3,  40 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "default/template/extension/module/image_option.twig", "");
    }
}

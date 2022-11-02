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

/* stroimarket/template/product/product.twig */
class __TwigTemplate_3006694cfc4900c0ea4d71be9747a6637c453e63fce4cb477a96912f6181659a extends \Twig\Template
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
        echo ($context["header"] ?? null);
        echo "
<div id=\"product-product\">
  <section class=\"catalog-product__block product-content\">
    <div class=\"container\">
      <div class=\"catalog-product__container\">
        <div class=\"navigation-content\">
          <ul class=\"breadcrumb\">
            ";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["i"] => $context["breadcrumb"]) {
            echo " 
            ";
            // line 9
            if ((($context["i"] + 1) < twig_length_filter($this->env, ($context["breadcrumbs"] ?? null)))) {
                // line 10
                echo "            <li><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 10);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 10);
                echo "</a></li>
            ";
            } else {
                // line 12
                echo "            <li>";
                echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 12);
                echo "</li>
            ";
            }
            // line 13
            echo " 
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['i'], $context['breadcrumb'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 14
        echo "\t
          </ul>
          ";
        // line 16
        if (($context["back_history"] ?? null)) {
            // line 17
            echo "          <div class=\"back-history hidden-xs\"><a href=\"\" class=\"button-back\" onclick=\"window.history.back(); return false;\">";
            echo ($context["text_back"] ?? null);
            echo "</a></div>
          ";
        }
        // line 19
        echo "        </div>
        <div id=\"product\" class=\"product\">
          ";
        // line 21
        if (($context["back_history"] ?? null)) {
            // line 22
            echo "          <div class=\"back-history visible-xs\"><a href=\"\" class=\"button-back\" onclick=\"window.history.back(); return false;\">";
            echo ($context["text_back"] ?? null);
            echo "</a></div>
          ";
        }
        // line 24
        echo "          ";
        echo ($context["content_top"] ?? null);
        echo "
          <h1 class=\"main-title\">";
        // line 25
        echo ($context["heading_title"] ?? null);
        echo "</h1>
          <div class=\"row\">
            <div class=\"col-xl-9 col-md-7\">
              <div class=\"row\">
                          ";
        // line 29
        if ((($context["pmtemplate"] ?? null) == "productdver")) {
            // line 30
            echo "                                <div class=\"col-xl-5\">
                          ";
        } else {
            // line 32
            echo "                                <div class=\"col-xl-6\">
                        ";
        }
        // line 34
        echo "                  <div class=\"product-left\">
                    <div class=\"product-left-block\">
                      <div class=\"product-image\">
                        ";
        // line 37
        if ((($context["thumb"] ?? null) || ($context["images"] ?? null))) {
            // line 38
            echo "                        <ul class=\"thumbnails\">
                        
                                <!-- XD stickers start -->
            \t\t\t\t\t";
            // line 41
            if ( !twig_test_empty(($context["xdstickers"] ?? null))) {
                // line 42
                echo "            \t\t\t\t\t<li class=\"xdstickers_wrapper clearfix ";
                echo ($context["xdstickers_position"] ?? null);
                echo " xdstickers-leftprod\">
            \t\t\t\t\t\t";
                // line 43
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["xdstickers"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["xdsticker"]) {
                    // line 44
                    echo "    \t\t\t\t\t                    ";
                    if ((twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 44) == "left")) {
                        // line 45
                        echo "                        \t\t\t\t\t\t\t<div class=\"xdstickers ";
                        echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 45);
                        echo "\">
                        \t\t\t\t\t\t\t\t<div class=\"xdstickerbackground xdstickid";
                        // line 46
                        echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 46);
                        echo "\" data-html=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 46);
                        echo "\" style=\"background-image: url('/";
                        echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "imagestick", [], "any", false, false, false, 46);
                        echo "');\" alt=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 46);
                        echo "\" datatyp=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "typet", [], "any", false, false, false, 46);
                        echo "\" datatwo=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 46);
                        echo "\"></div>
                        \t\t\t\t\t\t\t</div>
                                            ";
                    }
                    // line 49
                    echo "            \t\t\t\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['xdsticker'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 50
                echo "            \t\t\t\t\t</li>
            \t\t\t\t\t";
            }
            // line 52
            echo "            \t\t\t\t\t<!-- XD stickers end -->
            \t\t\t\t\t
                                <!-- XD stickers start -->
            \t\t\t\t\t";
            // line 55
            if ( !twig_test_empty(($context["xdstickers"] ?? null))) {
                // line 56
                echo "            \t\t\t\t\t<li class=\"xdstickers_wrapper clearfix xdstickers-rightprod ";
                echo ($context["xdstickers_position"] ?? null);
                echo "\">
            \t\t\t\t\t\t";
                // line 57
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["xdstickers"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["xdsticker"]) {
                    // line 58
                    echo "    \t\t\t\t\t                    ";
                    if ((twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 58) == "right")) {
                        // line 59
                        echo "                        \t\t\t\t\t\t\t<div class=\"xdstickers ";
                        echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 59);
                        echo "\">
                        \t\t\t\t\t\t\t\t<div class=\"xdstickerbackground xdstickid";
                        // line 60
                        echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 60);
                        echo "\" data-html=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 60);
                        echo "\" style=\"background-image: url('/";
                        echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "imagestick", [], "any", false, false, false, 60);
                        echo "');\" alt=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 60);
                        echo "\" datatyp=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "typet", [], "any", false, false, false, 60);
                        echo "\" datatwo=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 60);
                        echo "\"></div>
                        \t\t\t\t\t\t\t</div>
                                            ";
                    }
                    // line 63
                    echo "            \t\t\t\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['xdsticker'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 64
                echo "            \t\t\t\t\t</li>
            \t\t\t\t\t";
            }
            // line 66
            echo "            \t\t\t\t\t<!-- XD stickers end -->
            \t\t\t\t\t
            \t\t\t\t\t
            \t\t\t\t\t
            \t\t\t\t\t
            \t\t\t\t\t
            \t\t\t\t\t
                        
                          ";
            // line 74
            if (($context["thumb"] ?? null)) {
                // line 75
                echo "                          <li><a class=\"thumbnail\" href=\"";
                echo ($context["popup"] ?? null);
                echo "\" title=\"";
                echo ($context["heading_title"] ?? null);
                echo "\"><img src=\"";
                echo ($context["thumb"] ?? null);
                echo "\" title=\"";
                echo ($context["heading_title"] ?? null);
                echo "\" alt=\"";
                echo ($context["heading_title"] ?? null);
                echo "\" /></a></li>
            ";
            }
            // line 77
            echo "                          ";
            if (($context["images"] ?? null)) {
                // line 78
                echo "                          ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["images"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["image"]) {
                    // line 79
                    echo "                          <li class=\"image-additional\"><a class=\"thumbnail\" href=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["image"], "popup", [], "any", false, false, false, 79);
                    echo "\" title=\"";
                    echo ($context["heading_title"] ?? null);
                    echo "\"> <img src=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["image"], "thumb", [], "any", false, false, false, 79);
                    echo "\" title=\"";
                    echo ($context["heading_title"] ?? null);
                    echo "\" alt=\"";
                    echo ($context["heading_title"] ?? null);
                    echo "\" /></a></li>
            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['image'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 81
                echo "                          ";
            }
            // line 82
            echo "                        </ul>
                        ";
        }
        // line 84
        echo "                      </div>
                      \t<div class=\"more-photo\"><a href=\"#callback\" class=\"callback\">Нужно больше фото живых образцов? Оперативно вышлем больше фото и видео образца из шоурума</a></div>
                    </div>
                  </div>
                        
                          ";
        // line 89
        if ((($context["pmtemplate"] ?? null) == "productdver")) {
            // line 90
            echo "                          
          <a href=\"#view-interior\" class=\"view-interior-a\"><div class=\"view-interior\"><img src=\"/image/interior/view-interior.png\" class=\"view-interior-img\"></div></a>

        <script type=\"text/javascript\">
          \$('.mfp-gallery').magnificPopup({
          mainClass: 'mfp-zoom-in',
          type: 'image',
          tLoading: '',
          gallery:{
            enabled:true,
          },
          removalDelay: 300,
          callbacks: {
            beforeChange: function() {
              this.items[0].src = this.items[0].src + '?=' + Math.random(); 
            },
            open: function() {
              \$.magnificPopup.instance.next = function() {
                var self = this;
                self.wrap.removeClass('mfp-image-loaded');
                setTimeout(function() { \$.magnificPopup.proto.next.call(self); }, 120);
              }
              \$.magnificPopup.instance.prev = function() {
                var self = this;
                self.wrap.removeClass('mfp-image-loaded');
                setTimeout(function() { \$.magnificPopup.proto.prev.call(self); }, 120);
              }
            },
            imageLoadComplete: function() { 
              var self = this;
              setTimeout(function() { self.wrap.addClass('mfp-image-loaded'); }, 16);
            }
          }
        });
                </script>
                <script type=\"text/javascript\">
            \$('#slideshow3').owlCarousel({
          items: 1,
          autoPlay: false,
          singleItem: true,
          navigation: true,
          navigationText: ['<i class=\"fa fa-chevron-left fa-5x\"></i>', '<i class=\"fa fa-chevron-right fa-5x\"></i>'],
          pagination: false
        });
        </script>
                  
                        ";
        }
        // line 137
        echo "                  
                  
                  
                </div>
                
                    
                          ";
        // line 143
        if ((($context["pmtemplate"] ?? null) == "productdver")) {
            // line 144
            echo "                                <div class=\"col-xl-7\" id=\"prodafthpm\">
                          ";
        } else {
            // line 146
            echo "                                <div class=\"col-xl-6\" id=\"prodafthpm\">
                        ";
        }
        // line 148
        echo "                
                <!--
product variant
//-->

";
        // line 153
        if (($context["variantproducts"] ?? null)) {
            // line 154
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["variantproducts"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["variantproduct"]) {
                // line 155
                echo "<h3>";
                echo twig_get_attribute($this->env, $this->source, $context["variantproduct"], "title", [], "any", false, false, false, 155);
                echo "</h3>
";
                // line 156
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["variantproduct"], "products", [], "any", false, false, false, 156));
                foreach ($context['_seq'] as $context["_key"] => $context["product"]) {
                    // line 157
                    echo "<a href=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "href", [], "any", false, false, false, 157);
                    echo "\" id=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "product_id", [], "any", false, false, false, 157);
                    echo "\" class=\"product_variants\"><img src=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "image", [], "any", false, false, false, 157);
                    echo "\"  data-toggle=\"tooltip\" class=\"img-thumbnail\" title=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 157);
                    echo "\" alt=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 157);
                    echo "\" /></a>
";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['product'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['variantproduct'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 161
        echo "

<!--
product variant
//-->
                
                
                  ";
        // line 168
        if (($context["options"] ?? null)) {
            // line 169
            echo "                  <div class=\"product-options\">
                    ";
            // line 170
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["options"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
                // line 171
                echo "                    ";
                if ((twig_get_attribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 171) == "select")) {
                    // line 172
                    echo "                    <div class=\"form-group";
                    if (twig_get_attribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 172)) {
                        echo " required ";
                    }
                    echo "\">
                      <label class=\"control-label\" for=\"input-option";
                    // line 173
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 173);
                    echo "\">";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 173);
                    echo "</label>
                      <select name=\"option[";
                    // line 174
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 174);
                    echo "]\" id=\"input-option";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 174);
                    echo "\" class=\"form-control\">
                        <option value=\"\">";
                    // line 175
                    echo ($context["text_select"] ?? null);
                    echo "</option>
                        ";
                    // line 176
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["option"], "product_option_value", [], "any", false, false, false, 176));
                    foreach ($context['_seq'] as $context["_key"] => $context["option_value"]) {
                        // line 177
                        echo "                        <option value=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["option_value"], "product_option_value_id", [], "any", false, false, false, 177);
                        echo "\">";
                        echo twig_get_attribute($this->env, $this->source, $context["option_value"], "name", [], "any", false, false, false, 177);
                        echo "
                          ";
                        // line 178
                        if (twig_get_attribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 178)) {
                            // line 179
                            echo "                          (";
                            echo twig_get_attribute($this->env, $this->source, $context["option_value"], "price_prefix", [], "any", false, false, false, 179);
                            echo twig_get_attribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 179);
                            echo ")
                          ";
                        }
                        // line 180
                        echo " 
                        </option>
                        ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['option_value'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 183
                    echo "                      </select>
                    </div>
                    ";
                }
                // line 186
                echo "                    ";
                if ((twig_get_attribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 186) == "radio")) {
                    // line 187
                    echo "                    <div class=\"form-group";
                    if (twig_get_attribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 187)) {
                        echo " required ";
                    }
                    echo "\">
                      <label class=\"control-label\">";
                    // line 188
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 188);
                    echo "</label>
                      <div id=\"input-option";
                    // line 189
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 189);
                    echo "\">
                        ";
                    // line 190
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["option"], "product_option_value", [], "any", false, false, false, 190));
                    foreach ($context['_seq'] as $context["_key"] => $context["option_value"]) {
                        // line 191
                        echo "                        <div class=\"radio fake-radio\">                 
                          <input type=\"radio\" id=\"";
                        // line 192
                        echo twig_get_attribute($this->env, $this->source, $context["option_value"], "product_option_value_id", [], "any", false, false, false, 192);
                        echo "\" name=\"option[";
                        echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 192);
                        echo "]\" value=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["option_value"], "product_option_value_id", [], "any", false, false, false, 192);
                        echo "\" />
                          <label class=\"option-btn radio-btn\" data-toggle=\"tooltip\" for=\"";
                        // line 193
                        echo twig_get_attribute($this->env, $this->source, $context["option_value"], "product_option_value_id", [], "any", false, false, false, 193);
                        echo "\">
                            ";
                        // line 194
                        if ( !twig_get_attribute($this->env, $this->source, $context["option_value"], "image", [], "any", false, false, false, 194)) {
                            // line 195
                            echo "                            <span class=\"option-name\" data-toggle=\"tooltip\" title=\"";
                            if (twig_get_attribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 195)) {
                                echo " ";
                                echo twig_get_attribute($this->env, $this->source, $context["option_value"], "price_prefix", [], "any", false, false, false, 195);
                                echo " ";
                                echo twig_get_attribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 195);
                                echo " ";
                            }
                            echo "\">";
                            echo twig_get_attribute($this->env, $this->source, $context["option_value"], "name", [], "any", false, false, false, 195);
                            echo "</span>
                            ";
                        } else {
                            // line 197
                            echo "                            <span class=\"option-image\" data-toggle=\"tooltip\" title=\"";
                            echo twig_get_attribute($this->env, $this->source, $context["option_value"], "name", [], "any", false, false, false, 197);
                            echo " ";
                            if (twig_get_attribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 197)) {
                                echo " ";
                                echo twig_get_attribute($this->env, $this->source, $context["option_value"], "price_prefix", [], "any", false, false, false, 197);
                                echo " ";
                                echo twig_get_attribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 197);
                                echo " ";
                            }
                            echo "\">
                              <img src=\"";
                            // line 198
                            echo twig_get_attribute($this->env, $this->source, $context["option_value"], "image", [], "any", false, false, false, 198);
                            echo "\" alt=\"";
                            echo twig_get_attribute($this->env, $this->source, $context["option_value"], "name", [], "any", false, false, false, 198);
                            echo "\" class=\"img-thumbnail\" />
                            </span>
                            ";
                        }
                        // line 200
                        echo " 
                          </label>
                        </div>
                        ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['option_value'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 204
                    echo "                      </div>
                    </div>
                    ";
                }
                // line 207
                echo "                    ";
                if ((twig_get_attribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 207) == "checkbox")) {
                    // line 208
                    echo "                    <div class=\"form-group";
                    if (twig_get_attribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 208)) {
                        echo " required ";
                    }
                    echo "\">
                      <label class=\"control-label\">";
                    // line 209
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 209);
                    echo "</label>
                      <div id=\"input-option";
                    // line 210
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 210);
                    echo "\">
                        ";
                    // line 211
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["option"], "product_option_value", [], "any", false, false, false, 211));
                    foreach ($context['_seq'] as $context["_key"] => $context["option_value"]) {
                        // line 212
                        echo "                        <div class=\"radio fake-checkbox\">                
                          <input type=\"checkbox\" id=\"";
                        // line 213
                        echo twig_get_attribute($this->env, $this->source, $context["option_value"], "product_option_value_id", [], "any", false, false, false, 213);
                        echo "\" name=\"option[";
                        echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 213);
                        echo "][]\" value=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["option_value"], "product_option_value_id", [], "any", false, false, false, 213);
                        echo "\" />
                          <label class=\"option-btn checkbox-btn\" for=\"";
                        // line 214
                        echo twig_get_attribute($this->env, $this->source, $context["option_value"], "product_option_value_id", [], "any", false, false, false, 214);
                        echo "\">
                            ";
                        // line 215
                        if ( !twig_get_attribute($this->env, $this->source, $context["option_value"], "image", [], "any", false, false, false, 215)) {
                            // line 216
                            echo "                            <span class=\"option-name\" data-toggle=\"tooltip\" title=\"";
                            if (twig_get_attribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 216)) {
                                echo " ";
                                echo twig_get_attribute($this->env, $this->source, $context["option_value"], "price_prefix", [], "any", false, false, false, 216);
                                echo " ";
                                echo twig_get_attribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 216);
                                echo " ";
                            }
                            echo "\">";
                            echo twig_get_attribute($this->env, $this->source, $context["option_value"], "name", [], "any", false, false, false, 216);
                            echo "</span>
                            ";
                        } else {
                            // line 218
                            echo "                            <span class=\"option-image\" data-toggle=\"tooltip\" title=\"";
                            echo twig_get_attribute($this->env, $this->source, $context["option_value"], "name", [], "any", false, false, false, 218);
                            echo " ";
                            if (twig_get_attribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 218)) {
                                echo " ";
                                echo twig_get_attribute($this->env, $this->source, $context["option_value"], "price_prefix", [], "any", false, false, false, 218);
                                echo " ";
                                echo twig_get_attribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 218);
                                echo " ";
                            }
                            echo "\">
                              <img src=\"";
                            // line 219
                            echo twig_get_attribute($this->env, $this->source, $context["option_value"], "image", [], "any", false, false, false, 219);
                            echo "\" alt=\"";
                            echo twig_get_attribute($this->env, $this->source, $context["option_value"], "name", [], "any", false, false, false, 219);
                            echo "\" class=\"img-thumbnail\" />
                            </span>
                            ";
                        }
                        // line 221
                        echo " 
                          </label>
                        </div>
                        ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['option_value'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 225
                    echo "                      </div>
                    </div>
                    ";
                }
                // line 228
                echo "                    ";
                if ((twig_get_attribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 228) == "text")) {
                    // line 229
                    echo "                    <div class=\"form-group";
                    if (twig_get_attribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 229)) {
                        echo " required ";
                    }
                    echo "\">
                      <label class=\"control-label\" for=\"input-option";
                    // line 230
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 230);
                    echo "\">";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 230);
                    echo "</label>
                      <input type=\"text\" name=\"option[";
                    // line 231
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 231);
                    echo "]\" value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "value", [], "any", false, false, false, 231);
                    echo "\" placeholder=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 231);
                    echo "\" id=\"input-option";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 231);
                    echo "\" class=\"form-control\" />
                    </div>
                    ";
                }
                // line 234
                echo "                    ";
                if ((twig_get_attribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 234) == "textarea")) {
                    // line 235
                    echo "                    <div class=\"form-group";
                    if (twig_get_attribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 235)) {
                        echo " required ";
                    }
                    echo "\">
                      <label class=\"control-label\" for=\"input-option";
                    // line 236
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 236);
                    echo "\">";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 236);
                    echo "</label>
                      <textarea name=\"option[";
                    // line 237
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 237);
                    echo "]\" rows=\"5\" placeholder=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 237);
                    echo "\" id=\"input-option";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 237);
                    echo "\" class=\"form-control\">";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "value", [], "any", false, false, false, 237);
                    echo "</textarea>
                    </div>
                    ";
                }
                // line 240
                echo "                    ";
                if ((twig_get_attribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 240) == "file")) {
                    // line 241
                    echo "                    <div class=\"form-group";
                    if (twig_get_attribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 241)) {
                        echo " required ";
                    }
                    echo "\">
                      <label class=\"control-label\">";
                    // line 242
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 242);
                    echo "</label>
                      <button type=\"button\" id=\"button-upload";
                    // line 243
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 243);
                    echo "\" data-loading-text=\"";
                    echo ($context["text_loading"] ?? null);
                    echo "\" class=\"btn btn-default btn-block\"><i class=\"fa fa-upload\"></i> ";
                    echo ($context["button_upload"] ?? null);
                    echo "</button>
                      <input type=\"hidden\" name=\"option[";
                    // line 244
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 244);
                    echo "]\" value=\"\" id=\"input-option";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 244);
                    echo "\" />
                    </div>
                    ";
                }
                // line 247
                echo "                    ";
                if ((twig_get_attribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 247) == "date")) {
                    // line 248
                    echo "                    <div class=\"form-group";
                    if (twig_get_attribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 248)) {
                        echo " required ";
                    }
                    echo "\">
                      <label class=\"control-label\" for=\"input-option";
                    // line 249
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 249);
                    echo "\">";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 249);
                    echo "</label>
                      <div class=\"input-group date\">
                        <input type=\"text\" name=\"option[";
                    // line 251
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 251);
                    echo "]\" value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "value", [], "any", false, false, false, 251);
                    echo "\" data-date-format=\"YYYY-MM-DD\" id=\"input-option";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 251);
                    echo "\" class=\"form-control\" />
                        <span class=\"input-group-btn\">
                          <button class=\"btn btn-default\" type=\"button\"><i class=\"fa fa-calendar\"></i></button>
                        </span>
                      </div>
                    </div>
                    ";
                }
                // line 258
                echo "                    ";
                if ((twig_get_attribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 258) == "datetime")) {
                    // line 259
                    echo "                    <div class=\"form-group";
                    if (twig_get_attribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 259)) {
                        echo " required ";
                    }
                    echo "\">
                      <label class=\"control-label\" for=\"input-option";
                    // line 260
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 260);
                    echo "\">";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 260);
                    echo "</label>
                      <div class=\"input-group datetime\">
                        <input type=\"text\" name=\"option[";
                    // line 262
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 262);
                    echo "]\" value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "value", [], "any", false, false, false, 262);
                    echo "\" data-date-format=\"YYYY-MM-DD HH:mm\" id=\"input-option";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 262);
                    echo "\" class=\"form-control\" />
                        <span class=\"input-group-btn\">
                          <button type=\"button\" class=\"btn btn-default\"><i class=\"fa fa-calendar\"></i></button>
                        </span>
                      </div>
                    </div>
                    ";
                }
                // line 269
                echo "                    ";
                if ((twig_get_attribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 269) == "time")) {
                    // line 270
                    echo "                    <div class=\"form-group";
                    if (twig_get_attribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 270)) {
                        echo " required ";
                    }
                    echo "\">
                      <label class=\"control-label\" for=\"input-option";
                    // line 271
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 271);
                    echo "\">";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 271);
                    echo "</label>
                      <div class=\"input-group time\">
                        <input type=\"text\" name=\"option[";
                    // line 273
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 273);
                    echo "]\" value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "value", [], "any", false, false, false, 273);
                    echo "\" data-date-format=\"HH:mm\" id=\"input-option";
                    echo twig_get_attribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 273);
                    echo "\" class=\"form-control\" />
                        <span class=\"input-group-btn\">
                          <button type=\"button\" class=\"btn btn-default\"><i class=\"fa fa-calendar\"></i></button>
                        </span>
                      </div>
                    </div>
                    ";
                }
                // line 280
                echo "                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['option'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 281
            echo "                  </div>
                  ";
        }
        // line 283
        echo "                  ";
        if (($context["recurrings"] ?? null)) {
            // line 284
            echo "                  <hr>
                  <h3>";
            // line 285
            echo ($context["text_payment_recurring"] ?? null);
            echo "</h3>
                  <div class=\"form-group required\">
                    <select name=\"recurring_id\" class=\"form-control\">
                      <option value=\"\">";
            // line 288
            echo ($context["text_select"] ?? null);
            echo "</option>
                      ";
            // line 289
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["recurrings"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["recurring"]) {
                // line 290
                echo "                      <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["recurring"], "recurring_id", [], "any", false, false, false, 290);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["recurring"], "name", [], "any", false, false, false, 290);
                echo "</option>
                      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['recurring'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 292
            echo "                    </select>
                    <div class=\"help-block\" id=\"recurring-description\"></div>
                  </div>
                  ";
        }
        // line 296
        echo "                  
                  
                        
                          ";
        // line 299
        if ((($context["pmtemplate"] ?? null) == "productdver")) {
            // line 300
            echo "                          ";
        } else {
            // line 301
            echo "                                  <div class=\"list-attributes\">
                                    <div class=\"list-attributes__title\">";
            // line 302
            echo ($context["text_about_product"] ?? null);
            echo "</div>
                                    <ul class=\"list-informations\">
                                      ";
            // line 304
            if (($context["manufacturer"] ?? null)) {
                // line 305
                echo "                                      <li class=\"list-li\">
                                        <div class=\"list-col list-li__left\">
                                          <span class=\"li-name\">";
                // line 307
                echo ($context["text_manufacturer"] ?? null);
                echo "</span>
                                        </div>
                                        <div class=\"list-col list-li__right\">
                                          <a href=\"";
                // line 310
                echo ($context["manufacturers"] ?? null);
                echo "\">";
                echo ($context["manufacturer"] ?? null);
                echo "</a>
                                        </div>
                                      </li>
                                      ";
            }
            // line 314
            echo "                                      ";
            if (($context["attributes"] ?? null)) {
                // line 315
                echo "                                      ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_slice($this->env, ($context["attributes"] ?? null), 0, 5));
                foreach ($context['_seq'] as $context["_key"] => $context["attribute"]) {
                    // line 316
                    echo "                                      <li class=\"list-li\">
                                        <div class=\"list-col list-li__left\">
                                          <span class=\"li-name\">";
                    // line 318
                    echo twig_get_attribute($this->env, $this->source, $context["attribute"], "name", [], "any", false, false, false, 318);
                    echo ":</span>
                                        </div>
                                        <div class=\"list-col list-li__right\">";
                    // line 320
                    echo twig_get_attribute($this->env, $this->source, $context["attribute"], "text", [], "any", false, false, false, 320);
                    echo "</div>
                                      </li>
                                      ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attribute'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 323
                echo "                                      <li class=\"all-tech\"><a href=\"\" onclick=\"\$('a[href=\\'#tab-specification\\']').trigger('click');  \$('html, body').animate({ scrollTop: \$('a[href=\\'#tab-specification\\']').offset().top - 100}, 500); return false;\">";
                echo ($context["text_all_attributes"] ?? null);
                echo "</a></li>
                                      ";
            }
            // line 325
            echo "                                    </ul>
                                  </div>
                        ";
        }
        // line 328
        echo "                  
                  <div class=\"consult\">Получите бесплатную консультацию специалиста:<br><a href=\"tel:+74993481116\" style=\"font-weight:bold;color:#243682;\">+7 (499) 348-11-16</a></div>
                  <div class=\"product-tools form-group\">
                <div class=\"btn-addtools d-flex\">
                  <button type=\"button\" class=\"product-compare tools-toggle clear-button\" onclick=\"compare.add('";
        // line 332
        echo ($context["product_id"] ?? null);
        echo "');\" data-toggle=\"tooltip\" title=\"";
        echo ($context["button_compare"] ?? null);
        echo "\"><i class=\"fi fi-rr-duplicate\"></i></button>
                  <button type=\"button\" class=\"product-wishlist tools-toggle clear-button\" onclick=\"wishlist.add('";
        // line 333
        echo ($context["product_id"] ?? null);
        echo "');\" data-toggle=\"tooltip\" title=\"";
        echo ($context["button_wishlist"] ?? null);
        echo "\"><i class=\"fi fi-rr-heart\"></i></button>
                  <div class=\"product-share\" data-toggle=\"tooltip\" title=\"";
        // line 334
        echo ($context["text_share"] ?? null);
        echo "\">
                    <span class=\"dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"fi fi-rr-share\"></i></span>
                    <div class=\"product-share-block\">
                      <!-- Add Yandex Share -->
                      <script async src=\"https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js\"></script>
                      <script async src=\"https://yastatic.net/share2/share.js\"></script>
                      <div class=\"ya-share2\" data-services=\"vkontakte,facebook,odnoklassniki,viber,whatsapp,skype,telegram\"></div>
                      <!-- Add Yandex Share END -->
                    </div>
                  </div>
                  <div class=\"product-share\" data-toggle=\"tooltip\" title=\"";
        // line 344
        echo ($context["text_print"] ?? null);
        echo "\">
                    <a href=\"index.php?route=extension/module/print_version_product&print_id=";
        // line 345
        echo ($context["product_id"] ?? null);
        echo "\" target=\"_blank\" data-toggle=\"tooltip\" title=\"";
        echo ($context["text_print"] ?? null);
        echo "\" data-effect=\"mfp-zoom-out\" class=\"btn tools-toggle clear-button\"><i class=\"fa fa-print\"></i></a>
                  </div>
                  
                </div>
              </div>
                  <div id=\"prodvar\">
                  
                  </div>
                  <div class=\"blockatributprod-img\">
\t\t\t\t</div>
                </div>
              </div>
            </div>
            <div class=\"col-xl-3 col-md-5\">
              
              <div class=\"product-right\">
           
            <div class=\"product-right-block\">
               ";
        // line 363
        if ((($context["minimum"] ?? null) > 1)) {
            // line 364
            echo "               <div class=\"product-minimum\">";
            echo ($context["text_minimum"] ?? null);
            echo "м2</div>
               ";
        }
        // line 366
        echo "               ";
        if (($context["price"] ?? null)) {
            // line 367
            echo "               <div class=\"product-prices\">
                  <div class=\"price\">
                     ";
            // line 369
            if ( !($context["special"] ?? null)) {
                // line 370
                echo "                     <div class=\"main-price\">";
                echo ($context["price"] ?? null);
                if (($context["mpn"] ?? null)) {
                    echo " за ";
                    echo ($context["mpn"] ?? null);
                }
                echo "</div>
                     ";
            } else {
                // line 372
                echo "                     <div class=\"product-item-price-stock\">
                        <div class=\"old-price product-item-price-old\">";
                // line 373
                echo ($context["price"] ?? null);
                echo "</div>
                        ";
                // line 374
                if (($context["economy"] ?? null)) {
                    // line 375
                    echo "                        <div class=\"product-item-price-economy\"> - ";
                    echo ($context["economy"] ?? null);
                    echo "</div>
                        ";
                }
                // line 377
                echo "                     </div>
                     <div class=\"main-price price-special price-new\">";
                // line 378
                echo ($context["special"] ?? null);
                if (($context["mpn"] ?? null)) {
                    echo " за ";
                    echo ($context["mpn"] ?? null);
                }
                echo "</div>
                     ";
            }
            // line 380
            echo "                     ";
            if (($context["tax"] ?? null)) {
                // line 381
                echo "                     <div class=\"price-tax\">";
                echo ($context["text_tax"] ?? null);
                echo " ";
                echo ($context["tax"] ?? null);
                echo "</div>
                     ";
            }
            // line 383
            echo "                     ";
            if (($context["points"] ?? null)) {
                // line 384
                echo "                     <div class=\"price-points\">";
                echo ($context["text_points"] ?? null);
                echo " <span>";
                echo ($context["points"] ?? null);
                echo "</span></div>
                     ";
            }
            // line 386
            echo "                  </div>
               </div>
               ";
        }
        // line 389
        echo "               ";
        if ((($context["price"] ?? null) == false)) {
            // line 390
            echo "               <div class=\"alert-price form-group\">";
            echo ($context["attention"] ?? null);
            echo "</div>
               ";
        }
        // line 392
        echo "               ";
        if (($context["price"] ?? null)) {
            // line 393
            echo "               ";
            if (($context["discounts"] ?? null)) {
                // line 394
                echo "               <h4>";
                echo ($context["text_table_price"] ?? null);
                echo "</h4>
               <div class=\"discount\">
                  ";
                // line 396
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["discounts"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["discount"]) {
                    // line 397
                    echo "                  <div class=\"price-discount\">
                     <span class=\"discount-item\">";
                    // line 398
                    echo twig_get_attribute($this->env, $this->source, $context["discount"], "quantity", [], "any", false, false, false, 398);
                    echo " ";
                    echo ($context["text_discount"] ?? null);
                    echo "</span>
                     <span class=\"discount-item-value\">
                        <span class=\"discount-item-bg\">";
                    // line 400
                    echo twig_get_attribute($this->env, $this->source, $context["discount"], "price", [], "any", false, false, false, 400);
                    if (($context["mpn"] ?? null)) {
                        echo " за ";
                        echo ($context["mpn"] ?? null);
                    }
                    echo "</span>
                     </span>
                  </div>
                  ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['discount'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 404
                echo "               </div>
               ";
            }
            // line 406
            echo "               ";
        }
        // line 407
        echo "               <div class=\"product-actions__block\">
                  ";
        // line 408
        if (($context["percent"] ?? null)) {
            // line 409
            echo "                  <div class=\"product-offers card-percent\"><span>";
            echo (("-" . ($context["percent"] ?? null)) . "%");
            echo "</span></div>
                  ";
        }
        // line 411
        echo "                  ";
        if ((($context["quantity"] ?? null) == 0)) {
            // line 412
            echo "                  <div class=\"product-offers product-stock not-available\"><span>";
            echo ($context["stock"] ?? null);
            echo "</span></div>
                  ";
        } else {
            // line 414
            echo "                  <div class=\"product-offers product-stock in-stock\"><span>";
            echo ($context["text_instock"] ?? null);
            echo "
                        <!--";
            // line 415
            if (($context["stock_display"] ?? null)) {
                echo ($context["stock"] ?? null);
                echo " ";
                echo ($context["text_pcs"] ?? null);
            }
            echo "-->
                     </span></div>
                  ";
        }
        // line 418
        echo "                  ";
        if ((($context["pmtemplate"] ?? null) == "productpol")) {
            // line 419
            echo "                     <a href=\"#callback\" class=\"zapas-podrezka zapas-podrezkastyle\">Запас<br> на подрезку</a>
                  ";
        }
        // line 421
        echo "               </div>
            
               ";
        // line 423
        if ((($context["pmtemplate"] ?? null) == "productpol")) {
            // line 424
            echo "
            
               <div class=\"card-order\">
                  <div class=\"doublediv\">
              <div class=\"rows-calc rows-calcpol1\">
                <div class=\"row-calc\">Ваша площадь:</div>
                <div class=\"row-calc ploshad-pl-mn\">
                  <span class=\"quant-pm quantminus\" id=\"minus-input-calc\">-</span>
                  <span class=\"sp-input\">
                    <input value=\"";
            // line 433
            echo ($context["minimum"] ?? null);
            echo "\" 
                      autocomplete=\"off\"
                      min=\"0\"
                      pricemain=\"2503\"
                      skidkatrue=\"1\"
                      priceskidk=\"";
            // line 438
            echo ($context["special"] ?? null);
            echo "\"
                      id=\"chislo\"
                      maxlength=\"6\"
                      type=\"text\"
                      id=\"chislo\"
                      class=\"calc-osnova\"/></span>
                  <span class=\"quant-pm quantplus\" id=\"plus-input-calc\">+</span>
                </div>
              </div>
              <div class=\"rows-calc rows-calcpol\">
                <div class=\"row-calc\">Кол-во пачек:</div>
                <div class=\"row-calc\">
                  <span class=\"quant-pm quantminus\" id=\"minus-input-calc2\">-</span>
                  <span class=\"sp-input\">
                    <input value=\"1\"
                      autocomplete=\"off\"
                      type=\"text\"
                      id=\"kolvopachek\"
                      maxlength=\"4\"
                      min=\"0\" />
                      </span>
                  <span class=\"quant-pm quantplus\" id=\"plus-input-calc2\"
                    >+</span>
                </div>
              </div>
            </div>
            
            <div>
               <div id=\"resultcalcflo\">
                  <p class=\"items-stoimost\">Общая стоимость: Price руб.</p>
                  <p class=\"double-info-stoimost\">1 упаковка ( м<sup>2</sup>)</p>
               </div>
            </div>
            <input type=\"hidden\" name=\"quantity\" value=\"";
            // line 471
            echo twig_get_attribute($this->env, $this->source, ($context["product"] ?? null), "minimum", [], "any", false, false, false, 471);
            echo "\" size=\"5\" id=\"input-quantity\" class=\"form-control\">
            <input type=\"hidden\" name=\"minimum\" value=\"";
            // line 472
            echo twig_get_attribute($this->env, $this->source, ($context["product"] ?? null), "minimum", [], "any", false, false, false, 472);
            echo "\" id=\"minimum\">
            <input type=\"hidden\" name=\"product_id\" value=\"";
            // line 473
            echo ($context["product_id"] ?? null);
            echo "\">
            <div class=\"pytnp\">
               <button type=\"button\" id=\"button-cart\" data-loading-text=\"Загрузка...\" class=\"btn btn-primary btn-lg btn-block\">В корзину</button>
            </div>
            </div>
            
               ";
        } else {
            // line 480
            echo "            
               <div class=\"product-buy add-cart-block\">
                  ";
            // line 482
            if ((($context["pmtemplate"] ?? null) == "productdver")) {
                // line 483
                echo "                  <div class=\"noneclassquant\">
                     ";
            } else {
                // line 485
                echo "                     ";
                if (($context["quantity_btn"] ?? null)) {
                    // line 486
                    echo "                     <div class=\"product-quantity\">
                        <span class=\"product-entry-qty\">";
                    // line 487
                    echo ($context["entry_qty"] ?? null);
                    echo "</span>
                        <div class=\"counter product-counter counter-style-1\">
                           <input type=\"text\" name=\"quantity\" value=\"";
                    // line 489
                    echo ($context["minimum"] ?? null);
                    echo "\" data-min=\"";
                    echo ($context["minimum"] ?? null);
                    echo "\"
                              data-max=\"";
                    // line 490
                    echo ($context["quantity"] ?? null);
                    echo "\" class=\"counter-input inputtwo\" id=\"cartquant\" />
                           <div class=\"counter-controls\">
                              <button class=\"counter-plus\" type=\"button\" aria-label=\"Button plus\"><i
                                    class=\"fi fi-rr-plus-small\"></i></button>
                              <button class=\"counter-minus\" type=\"button\" aria-label=\"Button minus\"><i
                                    class=\"fi-rr-minus-small\"></i></button>
                           </div>
                        </div>
                     </div>
                     ";
                }
                // line 500
                echo "                     ";
            }
            // line 501
            echo "                     <div class=\"product-buy-btn\">
                        <button type=\"button\" id=\"button-cart\" data-loading-text=\"";
            // line 502
            echo ($context["text_loading"] ?? null);
            echo "\"
                           class=\"btn btn-primary btn-lg btn-block\"><i class=\"fi fi-rr-shopping-cart-add\"></i><span
                              class=\"btn-cart__text\">";
            // line 504
            echo ($context["button_cart"] ?? null);
            echo "</span></button>
                        <input type=\"hidden\" name=\"product_id\" value=\"";
            // line 505
            echo ($context["product_id"] ?? null);
            echo "\" />
                     </div>
                     <div id=\"buyoneclick\"></div>
                     <div class=\"whatsapp-prod\"> <a
                           href=\"https://api.whatsapp.com/send/?phone=74993481116&text=Добрый+день%2C+вышлите+предложение+по+";
            // line 509
            echo twig_get_attribute($this->env, $this->source, ($context["product"] ?? null), "name", [], "any", false, false, false, 509);
            echo "\">Перейти
                           в чат
                           <svg height=\"13pt\" viewBox=\"-1 0 512 512\" width=\"13pt\" xmlns=\"http://www.w3.org/2000/svg\">
                              <path
                                 d=\"m10.894531 512c-2.875 0-5.671875-1.136719-7.746093-3.234375-2.734376-2.765625-3.789063-6.78125-2.761719-10.535156l33.285156-121.546875c-20.722656-37.472656-31.648437-79.863282-31.632813-122.894532.058594-139.941406 113.941407-253.789062 253.871094-253.789062 67.871094.0273438 131.644532 26.464844 179.578125 74.433594 47.925781 47.972656 74.308594 111.742187 74.289063 179.558594-.0625 139.945312-113.945313 253.800781-253.867188 253.800781 0 0-.105468 0-.109375 0-40.871093-.015625-81.390625-9.976563-117.46875-28.84375l-124.675781 32.695312c-.914062.238281-1.84375.355469-2.761719.355469zm0 0\" fill=\"#01e675\" />
                              <path
                                 d=\"m10.894531 501.105469 34.46875-125.871094c-21.261719-36.839844-32.445312-78.628906-32.429687-121.441406.054687-133.933594 109.046875-242.898438 242.976562-242.898438 64.992188.027344 125.996094 25.324219 171.871094 71.238281 45.871094 45.914063 71.125 106.945313 71.101562 171.855469-.058593 133.929688-109.066406 242.910157-242.972656 242.910157-.007812 0 .003906 0 0 0h-.105468c-40.664063-.015626-80.617188-10.214844-116.105469-29.570313zm134.769531-77.75 7.378907 4.371093c31 18.398438 66.542969 28.128907 102.789062 28.148438h.078125c111.304688 0 201.898438-90.578125 201.945313-201.902344.019531-53.949218-20.964844-104.679687-59.09375-142.839844-38.132813-38.160156-88.832031-59.1875-142.777344-59.210937-111.394531 0-201.984375 90.566406-202.027344 201.886719-.015625 38.148437 10.65625 75.296875 30.875 107.445312l4.804688 7.640625-20.40625 74.5zm0 0\"
                                 fill=\"#fff\" />
                              <path
                                 d=\"m19.34375 492.625 33.277344-121.519531c-20.53125-35.5625-31.324219-75.910157-31.3125-117.234375.050781-129.296875 105.273437-234.488282 234.558594-234.488282 62.75.027344 121.644531 24.449219 165.921874 68.773438 44.289063 44.324219 68.664063 103.242188 68.640626 165.898438-.054688 129.300781-105.28125 234.503906-234.550782 234.503906-.011718 0 .003906 0 0 0h-.105468c-39.253907-.015625-77.828126-9.867188-112.085938-28.539063zm0 0\"
                                 fill=\"#01e675\" />
                              <g fill=\"#fff\">
                                 <path
                                    d=\"m10.894531 501.105469 34.46875-125.871094c-21.261719-36.839844-32.445312-78.628906-32.429687-121.441406.054687-133.933594 109.046875-242.898438 242.976562-242.898438 64.992188.027344 125.996094 25.324219 171.871094 71.238281 45.871094 45.914063 71.125 106.945313 71.101562 171.855469-.058593 133.929688-109.066406 242.910157-242.972656 242.910157-.007812 0 .003906 0 0 0h-.105468c-40.664063-.015626-80.617188-10.214844-116.105469-29.570313zm134.769531-77.75 7.378907 4.371093c31 18.398438 66.542969 28.128907 102.789062 28.148438h.078125c111.304688 0 201.898438-90.578125 201.945313-201.902344.019531-53.949218-20.964844-104.679687-59.09375-142.839844-38.132813-38.160156-88.832031-59.1875-142.777344-59.210937-111.394531 0-201.984375 90.566406-202.027344 201.886719-.015625 38.148437 10.65625 75.296875 30.875 107.445312l4.804688 7.640625-20.40625 74.5zm0 0\" />
                                 <path
                                    d=\"m195.183594 152.246094c-4.546875-10.109375-9.335938-10.3125-13.664063-10.488282-3.539062-.152343-7.589843-.144531-11.632812-.144531-4.046875 0-10.625 1.523438-16.1875 7.597657-5.566407 6.074218-21.253907 20.761718-21.253907 50.632812 0 29.875 21.757813 58.738281 24.792969 62.792969 3.035157 4.050781 42 67.308593 103.707031 91.644531 51.285157 20.226562 61.71875 16.203125 72.851563 15.191406 11.132813-1.011718 35.917969-14.6875 40.976563-28.863281 5.0625-14.175781 5.0625-26.324219 3.542968-28.867187-1.519531-2.527344-5.566406-4.046876-11.636718-7.082032-6.070313-3.035156-35.917969-17.726562-41.484376-19.75-5.566406-2.027344-9.613281-3.035156-13.660156 3.042969-4.050781 6.070313-15.675781 19.742187-19.21875 23.789063-3.542968 4.058593-7.085937 4.566406-13.15625 1.527343-6.070312-3.042969-25.625-9.449219-48.820312-30.132812-18.046875-16.089844-30.234375-35.964844-33.777344-42.042969-3.539062-6.070312-.058594-9.070312 2.667969-12.386719 4.910156-5.972656 13.148437-16.710937 15.171875-20.757812 2.023437-4.054688 1.011718-7.597657-.503906-10.636719-1.519532-3.035156-13.320313-33.058594-18.714844-45.066406zm0 0\"
                                    fill-rule=\"evenodd\" />
                              </g>
                           </svg></a></div>
                  </div>
               </div>
                  ";
        }
        // line 531
        echo "                  
                  ";
        // line 532
        if ((($context["pmtemplate"] ?? null) == "productdver")) {
            // line 533
            echo "                  <div class=\"offser\"><a href=\"#callback\" class=\"found-cheaper2\"><b class=\"b-desh\">Нашли дешевле или у Вас много дверей?</b><br>Оставьте заявку и мы сделаем индивидуальную скидку</a></div>
                  ";
        } else {
            // line 535
            echo "                  <div class=\"offser\"><a href=\"#found-cheaper\" class=\"found-cheaper2\"><b class=\"b-desh\">Нашли дешевле или у Вас большой метраж?</b><br>Оставьте заявку и мы сделаем индивидуальную скидку</a></div>
                  ";
        }
        // line 537
        echo "                  <div class=\"dostavka\">
                     <div class=\"info-dostavka\">
                        <ul class=\"info-dostavka-ul\">
                           <li class=\"info-dostavka-li\"><span>Доставка по Москве и МО (1500р. + 20р за км от МКАД)</span></li>
                           <li class=\"info-dostavka-li\"><span>Доставка в регионы осуществляется транспортными компаниями</span></li>
                        </ul>
                        <span class=\"head-dost\">Оплата</span>
                        <ul class=\"info-dostavka-ul\">
                           <li class=\"info-dostavka-li\"><span>Наличными в салоне-магазине</span></li>
                           <li class=\"info-dostavka-li\"><span>Оплата через сайт</span></li>
                           <li class=\"info-dostavka-li\"><span>Банковским переводом</span></li>
                        </ul>
                     </div>
                  </div>
                  </div>
                  </div>
                  </div>
                  <div>
                     <div class=\"menuprem-feat menuprem-just menuprem-dark menuprem-inline menuprem-feattop\">
                        <ul>
                           <li><a> <i class=\"icon-prem icon-dostavka\">&nbsp;</i> </a>
                              <div><a>Бесплатная доставка по Москве </a></div>
                              <span class=\"menuprem-dropdown\"
                                 data-text=\"Мы привезём любой заказ от 50000р, сделанный в нашем магазине бесплатно в пределах МКАД.\">
                                 <!--noindex-->Мы привезём любой заказ от 50000р, сделанный в нашем магазине бесплатно в пределах МКАД.
                                 <!--/noindex-->
                              </span>
                           </li>
                           <li><a> <i class=\"icon-prem icon-vozvrat\">&nbsp;</i> </a>
                              <div><a>Возврат-обмен товара </a></div>
                              <span class=\"menuprem-dropdown\"
                                 data-text=\"Возврат товаров осуществляется в соответствии с законом о Защите прав потребителей.\">
                                 <!--noindex-->Возврат товаров осуществляется в соответствии с законом о Защите прав потребителей.
                                 <!--/noindex-->
                              </span>
                           </li>
                           <li><a> <i class=\"icon-prem icon-sklad\">&nbsp; </i> </a>
                              <div><a>Бесплатное хранение товара </a></div>
                              <span class=\"menuprem-dropdown\"
                                 data-text=\"При необходимости, мы готовы бесплатно хранить любую вашу покупку на нашем складе в течении 2-х месяцев. Более длительное хранение возможно и является предметом взаимовыгодных соглашений.\">
                                 При необходимости, мы готовы бесплатно хранить любую вашу покупку на нашем складе в течении
                                 2-х месяцев. Более длительное хранение возможно и является предметом взаимовыгодных соглашений.
                              </span>
                           </li>
                           <li><a> <i class=\"icon-prem icon-garant\">&nbsp;</i> </a>
                              <div><a>Расширенная гарантия </a></div>
                              <span class=\"menuprem-dropdown\"
                                 data-text=\"При условии, что приобретённые у нас напольные покрытия будут смонтированы нашими специалистами, мы предоставляем расширенную до 3 лет гарантию от нашей компании.\">
                                 При условии, что приобретённые у нас напольные покрытия будут смонтированы нашими
                                 специалистами, мы предоставляем расширенную до 3 лет гарантию от нашей компании.
                              </span>
                           </li>
                           ";
        // line 589
        if ((($context["pmtemplate"] ?? null) == "productdver")) {
            // line 590
            echo "                           <li><a> <i class=\"icon-prem icon-plintus\">&nbsp;</i> </a>
                              <div><a>Любые аксессуары в цвет дверей </a></div>
                              <span class=\"menuprem-dropdown\" data-text=\"У нас можно заказать любой аксессуар в цвет межкомнатных дверей.\">У
                                 нас можно заказать любой аксессуар в цвет межкомнатных дверей.</span>
                           </li>
                           ";
        } else {
            // line 596
            echo "                           <li><a> <i class=\"icon-prem icon-plintus\">&nbsp;</i> </a>
                              <div><a>Любые аксессуары в цвет пола </a></div>
                              <span class=\"menuprem-dropdown\"
                                 data-text=\"У нас можно заказать любой аксессуар в цвет напольного покрытия. Плинтуса, переходные порожки\">
                                 У нас можно заказать любой аксессуар в цвет напольного покрытия. Плинтуса, переходные порожки и другое.
                                 Собственное производство.
                              </span>
                           </li>
                           ";
        }
        // line 605
        echo "                        </ul>
                     </div>
                     </div>

</div>
<div class=\"product-tabs\">
   <ul class=\"nav nav-tabs\">
      <li class=\"active\"><a href=\"#tab-description\" data-toggle=\"tab\">";
        // line 612
        echo ($context["tab_description"] ?? null);
        echo "</a></li>
      ";
        // line 613
        if (($context["attribute_groups"] ?? null)) {
            // line 614
            echo "      <li><a href=\"#tab-specification\" data-toggle=\"tab\">";
            echo ($context["tab_attribute"] ?? null);
            echo "</a></li>
      ";
        }
        // line 616
        echo "      ";
        if (($context["review_status"] ?? null)) {
            // line 617
            echo "      <li><a href=\"#tab-review\" data-toggle=\"tab\">";
            echo ($context["tab_review"] ?? null);
            echo "</a></li>
      ";
        }
        // line 619
        echo "      ";
        if ((($context["pmtemplate"] ?? null) == "productdver")) {
            // line 620
            echo "      <li><a href=\"#sistemopen-dvery\" data-toggle=\"tab\">Системы открывания</a></li>
      <li><a href=\"#pay-deliverydver\" data-toggle=\"tab\">Доставка и оплата</a></li>
      <li><a href=\"#montag-dvery\" data-toggle=\"tab\">Монтаж</a></li>
      ";
        }
        // line 624
        echo "      ";
        if ((($context["pmtemplate"] ?? null) == "productpol")) {
            // line 625
            echo "      <li><a href=\"#tab-podlojka\" data-toggle=\"tab\" aria-expanded=\"true\">Подложка</a></li>
      ";
        }
        // line 627
        echo "   </ul>
   <div class=\"tab-content\">
      <div class=\"tab-pane active\" id=\"tab-description\">
         <div class=\"h2\">";
        // line 630
        echo ($context["tab_description"] ?? null);
        echo "</div>
         <!-- XD stickers start -->
         ";
        // line 632
        if ( !twig_test_empty(($context["xdstickers"] ?? null))) {
            // line 633
            echo "         <div class=\"xdstickers_wrapper boooottom-stickers clearfix ";
            echo ($context["xdstickers_position"] ?? null);
            echo "\">
            ";
            // line 634
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["xdstickers"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["xdsticker"]) {
                // line 635
                echo "            ";
                if ((twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 635) == "bottom")) {
                    // line 636
                    echo "            <div class=\"xdstickers ";
                    echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 636);
                    echo "\">
               <div class=\"xdstickerbackground xdstickid";
                    // line 637
                    echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 637);
                    echo "\" data-html=\"true\" data-toggle=\"tooltip\"
                  data-placement=\"top\" data-original-title=\"";
                    // line 638
                    echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 638);
                    echo "\"
                  style=\"background-image: url('/";
                    // line 639
                    echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "imagestick", [], "any", false, false, false, 639);
                    echo "');\" alt=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 639);
                    echo "\"
                  datatyp=\"";
                    // line 640
                    echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "typet", [], "any", false, false, false, 640);
                    echo "\" datatwo=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 640);
                    echo "\"></div>
            </div>
            ";
                }
                // line 643
                echo "            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['xdsticker'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 644
            echo "         </div>
         ";
        }
        // line 646
        echo "         <!-- XD stickers end -->
         ";
        // line 647
        echo ($context["description"] ?? null);
        echo "
         <div class=\"proddescrakc\">
            <h3 class=\"akcdeqstv-h\">Действуют следующие акции на ";
        // line 649
        echo ($context["heading_title"] ?? null);
        echo "</h3>
            <!-- XD stickers start -->
            ";
        // line 651
        if ( !twig_test_empty(($context["xdstickers"] ?? null))) {
            // line 652
            echo "            ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["xdstickers"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["xdsticker"]) {
                // line 653
                echo "            ";
                if ((twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 653) == "left")) {
                    // line 654
                    echo "            <div class=\"xdstickers ";
                    echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 654);
                    echo "\">
               <div class=\"deystvakc\">";
                    // line 655
                    echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 655);
                    echo "</div>
            </div>
            <br>
            ";
                }
                // line 659
                echo "            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['xdsticker'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 660
            echo "            ";
        }
        // line 661
        echo "            ";
        if ( !twig_test_empty(($context["xdstickers"] ?? null))) {
            // line 662
            echo "            ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["xdstickers"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["xdsticker"]) {
                // line 663
                echo "            ";
                if ((twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 663) == "right")) {
                    // line 664
                    echo "            <div class=\"xdstickers ";
                    echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 664);
                    echo "\">
               <div class=\"deystvakc\">";
                    // line 665
                    echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 665);
                    echo "</div>
            </div>
            <br>
            ";
                }
                // line 669
                echo "            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['xdsticker'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 670
            echo "            ";
        }
        // line 671
        echo "            <!-- XD stickers end -->
         </div>
      </div>
                              ";
        // line 674
        if (($context["attribute_groups"] ?? null)) {
            // line 675
            echo "                              <div class=\"tab-pane\" id=\"tab-specification\">
                                 ";
            // line 676
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["attribute_groups"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["attribute_group"]) {
                // line 677
                echo "                                 ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["attribute_group"], "attribute", [], "any", false, false, false, 677));
                foreach ($context['_seq'] as $context["_key"] => $context["attribute"]) {
                    // line 678
                    echo "                                 <div class=\"table-list__item\">
                                    <div>";
                    // line 679
                    echo twig_get_attribute($this->env, $this->source, $context["attribute"], "name", [], "any", false, false, false, 679);
                    echo "</div>
                                    <div class=\"secondatttr\">";
                    // line 680
                    echo twig_get_attribute($this->env, $this->source, $context["attribute"], "text", [], "any", false, false, false, 680);
                    echo "</div>
                                 </div>
                                 ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attribute'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 683
                echo "                                 ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attribute_group'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 684
            echo "                              </div>
                              ";
            // line 685
            if ((($context["pmtemplate"] ?? null) == "productdver")) {
                // line 686
                echo "                              <div class=\"tab-pane\" id=\"sistemopen-dvery\">
                                 <div class=\"row sistem-opendver\">
                                    <div class=\"col-lg-4 col-sm-4 col-md-4 col-xs-6\">
                                       <a href=\"/sistema-otkryvaniya-kupe\">
                                          <img src=\"image/catalog/sistem-open/1452952820-1681649530.jpg\">
                                          <p>Купе</p>
                                       </a>
                                    </div>
                                    <div class=\"col-lg-4 col-sm-4 col-md-4 col-xs-6\">
                                       <a href=\"/sistema-compack\">
                                          <img src=\"image/catalog/sistem-open/1452952800-621121661.jpg\">
                                          <p>Compack</p>
                                       </a>
                                    </div>
                                    <div class=\"col-lg-4 col-sm-4 col-md-4 col-xs-6\">
                                       <a href=\"/sistema-otkryvaniya-knizhka\">
                                          <img src=\"image/catalog/sistem-open/1452952858-1164568791.jpg\">
                                          <p>Книжка</p>
                                       </a>
                                    </div>
                                    <div class=\"col-lg-4 col-sm-4 col-md-4 col-xs-6\">
                                       <a href=\"/sistema-otkryvaniya-magic\">
                                          <img src=\"image/catalog/sistem-open/1452952879-1693125004.jpg\">
                                          <p>Magic</p>
                                       </a>
                                    </div>
                                    <div class=\"col-lg-4 col-sm-4 col-md-4 col-xs-6\">
                                       <a href=\"/povorotnaya-sistema-otkryvaniya\">
                                          <img src=\"image/catalog/sistem-open/1452952900-506942101.jpg\">
                                          <p>Поворотная</p>
                                       </a>
                                    </div>
                                    <div class=\"col-lg-4 col-sm-4 col-md-4 col-xs-6\">
                                       <a href=\"/sistema-skrytyh-dverej-invisible\">
                                          <img src=\"image/catalog/sistem-open/1452952926-1005964045.jpg\">
                                          <p>Invisible</p>
                                       </a>
                                    </div>
                                    <div class=\"col-lg-4 col-sm-4 col-md-4 col-xs-6\">
                                       <a href=\"/sistema-otkryvaniya-izyda\">
                                          <img src=\"image/catalog/sistem-open/1.jpg\">
                                          <p>Izyda</p>
                                       </a>
                                    </div>
                                    <div class=\"col-lg-4 col-sm-4 col-md-4 col-xs-6\">
                                       <a href=\"/sistem-skrytyh-dverej-invisible-reverse\">
                                          <img src=\"image/catalog/sistem-open/232020.jpg\">
                                          <p>Invisible Reverse</p>
                                       </a>
                                    </div>
                                    <div class=\"col-lg-4 col-sm-4 col-md-4 col-xs-6\">
                                       <a href=\"/sistema-otkryvaniya-magic2-uniq\">
                                          <img src=\"image/catalog/sistem-open/10032020.jpg\">
                                          <p>Magic2 Uniq</p>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                              ";
            }
            // line 745
            echo "                              ";
            if ((($context["pmtemplate"] ?? null) == "productdver")) {
                // line 746
                echo "                              <div class=\"tab-pane\" id=\"pay-deliverydver\">
                                 <div class=\"row\">
                                    <div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-12\">
                                       <img class=\"deliveryprofil-img\" src=\"image/catalog/home-img/truck-mock-updostavka.jpg\">
                                    </div>
                                    <div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-12\">
                                       <div>
                                          <h3>Доставка</h3>
                                          <div>Москва и Московская область</div>
                                          <div>
                                             <b>Заказ от 30 000 руб. – БЕСПЛАТНО</b>
                                             + 30 руб./км за МКАД<br>
                                          </div>
                                          <div>
                                             Заказ до 30 000 руб. – стоимость доставки на объект или
                                             перемещение заказа в ШоуРум для самовывоза 3000р + 30 руб/км за МКАД
                                          </div>
                                          <p>Регионы РФ</p>
                                          <div>
                                             Заказ до 200 000 руб. – 2000 руб. до любой транспортной
                                             компании в Москве с экспедированием
                                          </div>
                                          <div>
                                             Заказ от 200 000 руб. – БЕСПЛАТНО до любой транспортной
                                             компании в Москве с экспедированием
                                          </div>
                                       </div>
                                       <div>
                                          <h3>Оплата</h3>
                                          <div>Оплата банковскими картами или наличными при получении.</div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              ";
            }
            // line 781
            echo "                              ";
            if ((($context["pmtemplate"] ?? null) == "productdver")) {
                // line 782
                echo "                              <div class=\"tab-pane\" id=\"montag-dvery\">
                                 <p><strong>Стоимость замера по Москве: межкомнатных дверей 500 рублей, входной двери 700 рублей. За МКАД (за 1 км) 35 руб.</strong></p>
                                 <p>Что входит в стандартную установку межкомнатных дверей</p>
                                 <ul>
                                    <li>сборка коробки</li>
                                    <li>врезка петель</li>
                                    <li>врезка обычной ручки-защелки</li>
                                    <li>навешивание полотна</li>
                                    <li>установка наличников с обеих сторон</li>
                                    <li>комплект расходных материалов на одну дверь (строительная пена, саморезы, гвозди)</li>
                                 </ul>
                                 <p><strong>В стоимость не входит:</strong></p>
                                 <ul>
                                    <li>демонтаж</li>
                                    <li>врезка сложного или сантехнического замка</li>
                                    <li>установка доборов</li>
                                 </ul>
                                 <p>Цены на установку стандартных межкомнатных дверей</p>
                                 <ul>
                                    <li>Установка одной двери (минимальный выезд) 3 600 руб.</li>
                                    <li>Установка двери (от 2-х шт.) стоимостью более 2000 руб. - 2 000 руб.</li>
                                    <li><strong>Установка двери (от 2-х шт.) телескоп, шпон и стоимостью более 2000 руб. - 2 200 руб.</strong></li>
                                    <li><strong>Установка двери (от 2-х шт.) эмаль, телескоп и стоимостью от 8000 руб. - 2 500 руб.</strong></li>
                                    <li>Установка двери с Компланарной коробкой (от 2-х шт.) \"Silvia\" на клей - 3 500 руб.</li>
                                    <li>Установка двустворчатой двери - 4 000 руб.</li>
                                    <li>Установка двустворчатой двери эмаль, телескоп и от 8000 руб. - 4 500 руб.</li>
                                    <li>Установка двери купе (без портала) ДЛЯ МОНТАЖА НУЖЕН БРУС 50Х50 - 2 500 руб.</li>
                                    <li>Установка стеклянной двери - 2 500 руб.</li>
                                    <li><strong>Установка двери из массива ценных пород дерева - 3 500 руб.</strong></li>
                                    <li>Установка двери книжка - 3 000 руб.</li>
                                    <li>Установка двери INVISIBLE - 2 800 руб.</li>
                                    <li>Установка арки - 2 500 руб.</li>
                                 </ul>
                              </div>
                              ";
            }
            // line 817
            echo "                              </div>
            ";
        }
        // line 819
        echo "            ";
        if (($context["review_status"] ?? null)) {
            // line 820
            echo "            <div class=\"tab-pane\" id=\"tab-review\">
              <div class=\"tab-reviews__title\">
                <div class=\"h2\">";
            // line 822
            echo ($context["tab_reviews"] ?? null);
            echo "</div>
                <button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#reviewsModal\">";
            // line 823
            echo ($context["text_write"] ?? null);
            echo "</button>
              </div>
              <form id=\"form-review\">
                <div id=\"review\"></div>
                <div class=\"modal fade\" id=\"reviewsModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"reviewsModalLabel\" aria-hidden=\"true\">
                  <div class=\"modal-dialog\" role=\"document\">
                    <div class=\"modal-content\">
                      <div class=\"modal-body\">
                        <div class=\"reviews-title__header\">
                          <div class=\"modal-title h2\" id=\"reviewsModalLabel\">";
            // line 832
            echo ($context["text_new_review"] ?? null);
            echo "</div>
                          <div class=\"reviews-subtitle\">";
            // line 833
            echo ($context["heading_title"] ?? null);
            echo "</div>
                          <button type=\"button\" class=\"close-btn\" data-dismiss=\"modal\" aria-label=\"Close\"><span class=\"close-icon__cross icon-cross__image\"></span></button>
                        </div>
                        <div class=\"form-review__card\">
                          ";
            // line 837
            if (($context["review_guest"] ?? null)) {
                // line 838
                echo "                          <div class=\"review-card\">
                            <div class=\"review-card__wrap\">
                              <div class=\"review-image\">
                                <div>
                                  <img src=\"";
                // line 842
                echo ($context["thumb"] ?? null);
                echo "\" title=\"";
                echo ($context["heading_title"] ?? null);
                echo "\" alt=\"";
                echo ($context["heading_title"] ?? null);
                echo "\" class=\"review-img\" />
                                  <div class=\"review-text\">";
                // line 843
                echo ($context["text_your_rating"] ?? null);
                echo "</div>
                                </div>
                              </div>
                              <div class=\"form-group required\">
                                <div class=\"stars-rating\">
                                  <input name=\"rating\" id=\"s_rating\" value=\"0\" type=\"hidden\">
                                  <div class=\"wrap\" data-rate=\"0\">
                                    <span data-toggle=\"tooltip\" title=\"";
                // line 850
                echo ($context["text_awful"] ?? null);
                echo "\" data-rate=\"1\"></span>
                                    <span data-toggle=\"tooltip\" title=\"";
                // line 851
                echo ($context["text_bad"] ?? null);
                echo "\" data-rate=\"2\"></span>
                                    <span data-toggle=\"tooltip\" title=\"";
                // line 852
                echo ($context["text_normal"] ?? null);
                echo "\" data-rate=\"3\"></span>
                                    <span data-toggle=\"tooltip\" title=\"";
                // line 853
                echo ($context["text_good"] ?? null);
                echo "\" data-rate=\"4\"></span>
                                    <span data-toggle=\"tooltip\" title=\"";
                // line 854
                echo ($context["text_excellent"] ?? null);
                echo "\" data-rate=\"5\"></span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class=\"form-group required flex flex-wrap-media\">
                            <label class=\"control-label form-label\" for=\"input-name\">";
                // line 861
                echo ($context["entry_name"] ?? null);
                echo "</label>
                            <div class=\"form-input\">
                              <input type=\"text\" name=\"name\" value=\"";
                // line 863
                echo ($context["customer_name"] ?? null);
                echo "\" id=\"input-name\" class=\"form-control form-review\" />
                            </div>
                          </div>
                          <div class=\"form-group required flex flex-wrap-media\">
                            <label class=\"control-label form-label\" for=\"input-review\">";
                // line 867
                echo ($context["entry_review"] ?? null);
                echo "</label>
                            <div class=\"form-input\">
                              <textarea name=\"text\" rows=\"5\" id=\"input-review\" class=\"form-control form-input form-review\"></textarea>
                            </div>
                          </div>
                          <div class=\"buttons\">
                            <button type=\"button\" id=\"button-review\" data-loading-text=\"";
                // line 873
                echo ($context["text_loading"] ?? null);
                echo "\" class=\"btn btn-primary\">";
                echo ($context["button_continue"] ?? null);
                echo "</button>
                          </div>
                          ";
                // line 875
                echo ($context["captcha"] ?? null);
                echo "
                          ";
            } else {
                // line 877
                echo "                          ";
                echo ($context["text_login"] ?? null);
                echo "\t
                          ";
            }
            // line 879
            echo "                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            ";
        }
        // line 887
        echo "            <div class=\"tab-pane\" id=\"tab-podlojka\"></div>
          </div>
          ";
        // line 889
        if (($context["tags"] ?? null)) {
            // line 890
            echo "          <div class=\"tags-container\">
            <div class=\"tags-title\">";
            // line 891
            echo ($context["text_product_tags"] ?? null);
            echo "</div>
            <div class=\"product-tags\">\t\t    
              ";
            // line 893
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(range(0, (twig_length_filter($this->env, ($context["tags"] ?? null)) - 1)));
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                // line 894
                echo "              ";
                if (($context["i"] < (twig_length_filter($this->env, ($context["tags"] ?? null)) - 1))) {
                    // line 895
                    echo "              <a href=\"";
                    echo twig_get_attribute($this->env, $this->source, (($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 = ($context["tags"] ?? null)) && is_array($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4) || $__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 instanceof ArrayAccess ? ($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4[$context["i"]] ?? null) : null), "href", [], "any", false, false, false, 895);
                    echo "\">";
                    echo twig_get_attribute($this->env, $this->source, (($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144 = ($context["tags"] ?? null)) && is_array($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144) || $__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144 instanceof ArrayAccess ? ($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144[$context["i"]] ?? null) : null), "tag", [], "any", false, false, false, 895);
                    echo "</a>
              ";
                } else {
                    // line 897
                    echo "              <a href=\"";
                    echo twig_get_attribute($this->env, $this->source, (($__internal_1cfccaec8dd2e8578ccb026fbe7f2e7e29ac2ed5deb976639c5fc99a6ea8583b = ($context["tags"] ?? null)) && is_array($__internal_1cfccaec8dd2e8578ccb026fbe7f2e7e29ac2ed5deb976639c5fc99a6ea8583b) || $__internal_1cfccaec8dd2e8578ccb026fbe7f2e7e29ac2ed5deb976639c5fc99a6ea8583b instanceof ArrayAccess ? ($__internal_1cfccaec8dd2e8578ccb026fbe7f2e7e29ac2ed5deb976639c5fc99a6ea8583b[$context["i"]] ?? null) : null), "href", [], "any", false, false, false, 897);
                    echo "\">";
                    echo twig_get_attribute($this->env, $this->source, (($__internal_68aa442c1d43d3410ea8f958ba9090f3eaa9a76f8de8fc9be4d6c7389ba28002 = ($context["tags"] ?? null)) && is_array($__internal_68aa442c1d43d3410ea8f958ba9090f3eaa9a76f8de8fc9be4d6c7389ba28002) || $__internal_68aa442c1d43d3410ea8f958ba9090f3eaa9a76f8de8fc9be4d6c7389ba28002 instanceof ArrayAccess ? ($__internal_68aa442c1d43d3410ea8f958ba9090f3eaa9a76f8de8fc9be4d6c7389ba28002[$context["i"]] ?? null) : null), "tag", [], "any", false, false, false, 897);
                    echo "</a>
              ";
                }
                // line 899
                echo "              ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 900
            echo "            </div>
          </div>
          ";
        }
        // line 903
        echo "        </div>
      </div>
       ";
        // line 905
        if ((($context["pmtemplate"] ?? null) == "productdver")) {
            // line 906
            echo "         <div id=\"zamer-categ-bottom\">
            <div class=\"container\" id=\"zamer-categ-bottom1\">
               <div>
                  <div class=\"zamer-main\">
                     <h3 class=\"zamer-maintitle\">
                        <span>Записаться на бесплатный замер</span>
                     </h3>
                     <form id=\"form-zamerdver\" class=\"ajax-form ajax-form-mail form-zamer\" action=\"\" method=\"post\"
                        enctype=\"multipart/form-data\">
                        <input type=\"hidden\" name=\"project_name\" value=\"Polmetra\">
                        <input type=\"hidden\" name=\"admin_email\" value=\"zakaz@polmetra.ru\">
                        <input type=\"hidden\" name=\"form_subject\" value=\"Форма Замер (Polmetra) Двери\">
                        <div class=\"form-dann\">
                           <div class=\"hiclass-form\">
                              <input type=\"text\" name=\"Name\" placeholder=\"Ваше имя...\">
                           </div>
                           <div class=\"forms-inputheadcall form-object-right\">
                              <input type=\"text\" name=\"NameTwo\" placeholder=\"Ваше имя...\">
                           </div>
                           <div class=\"form-object-right\">
                              <input class=\"form-control raz phone_masckcom\" type=\"tel\" id=\"phone1\" name=\"Телефон\" placeholder=\"Ваш телефон...\" required=\"\">
                           </div>
                        </div>
                        <div class=\"form-object_recv\">
                           <p>Введите номер телефона и наш менеджер перезвонит вам в течение <strong>15 минут</strong>.</p>
                           <span class=\"label\">Нажимая кнопку \"Отправить\", вы даёте согласие на обработку ваших персональных данных</span>
                        </div>
                        <div class=\"button-form-zamer\">
                           <button class=\"button-zakaz\">Отправить</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <section class=\"contbot\">
            <div class=\"container contbotdiv\">
               ";
            // line 943
            echo ($context["content_bottom"] ?? null);
            echo "
            </div>
         </section>
<div id=\"individual-offerprofil\">
   <div class=\"container\" id=\"individual-offerprofil1\">
      <div>
         <div class=\"individual-offerblockmain\">
            <div class=\"individual-offerblocktitle\">
               <h3><span>Получить индивидуальное предложение</span></h3>
            </div>
            <form id=\"individual-offerprofiltext\" class=\"ajax-form form-individualblock ajax-form-mail\" action=\"\"
               method=\"post\" enctype=\"multipart/form-data\">
               <input type=\"hidden\" name=\"project_name\" value=\"Polmetra\">
               <input type=\"hidden\" name=\"admin_email\" value=\"zakaz@polmetra.ru\">
               <input type=\"hidden\" name=\"form_subject\" value=\"Индивидуальное предложение (Polmetra) Двери\">
               <div class=\"form-individdann\">
                  <div class=\"hiclass-form\">
                     <input type=\"text\" name=\"Name\" placeholder=\"Ваше имя...\">
                  </div>
                  <div class=\"forms-inputheadcall\">
                     <input class=\"form-control form-control-individobject\" type=\"text\" name=\"NameTwo\"
                        placeholder=\"Ваше имя...\">
                  </div>
                  <div class=\"form-individobject\">
                     <input class=\"form-control form-control-individobject raz phone_masckcom\" type=\"tel\" id=\"phone1\"
                        name=\"Телефон\" placeholder=\"Ваш телефон...\" required=\"\">
                  </div>
                  <div class=\"form-individobject form-individobject-select form-control-individobject\">
                     <select class=\"individual-select\">
                        <option>Нужна максимальная % скидка %</option>
                        <option>Надо сравнить цены, есть расчёт</option>
                        <option>Лучше подарок от Профиль Дорс</option>
                        <option>Срочно! Нужны двери ещё вчера</option>
                     </select>
                     <input class=\"form-control\" type=\"hidden\" name=\"Предложение\" id=\"individual-inputsel\">
                  </div>
               </div>
               <div class=\"form-object_recv\">
                  <p>Введите номер телефона и наш менеджер перезвонит вам в течение <strong>15 минут</strong>.</p>
                  <span class=\"label\">Нажимая кнопку \"Отправить\", вы даёте согласие на обработку ваших персональных
                     данных</span>
               </div>
               <div class=\"button-individual-ofset\">
                  <button class=\"button-individual\">Отправить</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
   <script>
      var \$carsList = \$('#individual-inputsel'),
         carObj = {};
      carObj.length = 0;
      \$('.individual-select').change(function () {
         carObj[\$(this).index()] = \$(this).val();
         carObj.length = Object.keys(carObj).length - 1;
         \$carsList.val(Array.prototype.join.call(carObj, ', '));
      })
   </script>
   <script>
      \$('.toclick, .byeoneclick1, .view-interior-a').magnificPopup({
         mainClass: 'mfp-zoom-in',
         removalDelay: 400
      });
   </script>
<div class=\"hidden\">
  <div class=\"container\" style=\"top: -70px;\">
    <div id=\"view-interior\" class=\" callback-form product-popup\">
      <div class=\"formoneclickprod-title\">
      <h3>";
            // line 1013
            echo ($context["heading_title"] ?? null);
            echo " в интерьере</h3>
      </div>
      <div class=\"interior-background interior-form interior-form-bg-first\" id=\"bg-inter-change\">
        <a class=\"thumbnail mainimg-prod transparent-interior\" href=\"";
            // line 1016
            echo ($context["thumb"] ?? null);
            echo "\" title=\"";
            echo ($context["heading_title"] ?? null);
            echo "\"><img src=\"";
            echo ($context["thumb"] ?? null);
            echo "\" title=\"";
            echo ($context["heading_title"] ?? null);
            echo "\" alt=\"";
            echo ($context["heading_title"] ?? null);
            echo "\" /></a>
        
      </div>
        <div class=\"interiors-carousel\">
          <div class=\"interiors-carousel-item\" id=\"interior-first\">
            <img src=\"/image/interior/first.jpg\" class=\"interiors-img-item\">
          </div>
          <div class=\"interiors-carousel-item\" id=\"interior-second\">
            <img src=\"/image/interior/second.jpg\" class=\"interiors-img-item\">
          </div>
          <div class=\"interiors-carousel-item\" id=\"interior-three\">
            <img src=\"/image/interior/three.jpg\" class=\"interiors-img-item\">
          </div>
          <div class=\"interiors-carousel-item\" id=\"interior-four\">
            <img src=\"/image/interior/four.jpg\" class=\"interiors-img-item\">
          </div>
          <div class=\"interiors-carousel-item\" id=\"interior-five\">
            <img src=\"/image/interior/five.jpg\" class=\"interiors-img-item\">
          </div>
          <div class=\"interiors-carousel-item\" id=\"interior-six\">
            <img src=\"/image/interior/six.jpg\" class=\"interiors-img-item\">
          </div>
          
        </div>
    </div>
  </div>
</div>
<div class=\"hidden\">
   <div class=\"container\">
      <div id=\"found-cheaper\" class=\"callback-form product-popup\">
         <div class=\"formoneclickprod-title\">
            <h3>Нашли этот товар дешевле?</h3>
         </div>
         <div class=\"formoneclickprod-main\">
            <form id=\"found-cheaperform\" class=\"forma-qwest forms-sfloor-popu\">
               <input type=\"hidden\" name=\"project_name\" value=\"Polmetra\">
               <input type=\"hidden\" name=\"admin_email\" value=\"zakaz@polmetra.ru\">
               <input type=\"hidden\" name=\"form_subject\" value=\"Форма - Нашли дешевле (Polmetra)\">
               <input type=\"hidden\" name=\"Name-product\" value=\"";
            // line 1054
            echo ($context["heading_title"] ?? null);
            echo "\">
               <div class=\"hiclass-form\">
                  <input type=\"text\" name=\"Name\" placeholder=\"Ваше имя...\">
               </div>
               <div class=\"forms-inputheadcall\">
                  <input type=\"text\" name=\"NameTwo\" placeholder=\"Ваше имя...\">
               </div>
               <div class=\"forms-inputbyeoneclick\">
                  <input class=\"phone_masckcom\" type=\"text\" name=\"Phone\" placeholder=\"Ваш телефон...\" required>
               </div>
               <div class=\"forms-inputbyeoneclick\">
                  Ссылка на товар в другом магазине
                  <input type=\"text\" name=\"Link\" placeholder=\"Ссылка...\">
               </div>
               <div class=\"forms-byeoneclickbutton\">
               <button class=\"popup-a-button-form\">Применить</button>
               </div>
            </form>
         </div>
         <div class=\"success\">Сообщение отправлено</div>
      </div>
   </div>
</div>

            ";
        }
        // line 1079
        echo "            ";
        if ((($context["pmtemplate"] ?? null) == "productpol")) {
            // line 1080
            echo "            <section class=\"forma-productpred\">
               <div class=\"form-prodpredcall\">
                  <div class=\"container containeradapt\">
                     <div class=\"row\">
                        <form id=\"forma-podpred\" class=\"forma-qwest forms-sfloor-popu\">
                           <!-- Hidden Required Fields -->
                           <input type=\"hidden\" name=\"project_name\" value=\"Polmetra\">
                           <input type=\"hidden\" name=\"admin_email\" value=\"zakaz@polmetra.ru\">
                           <input type=\"hidden\" name=\"form_subject\" value=\"Форма - Подбор покрытия (Polmetra)\">
                           <input type=\"hidden\" name=\"Name-product\" value=\"";
            // line 1089
            echo ($context["heading_title"] ?? null);
            echo "\">
                           <!-- END Hidden Required Fields -->
                           <div class=\"forms-inputprod\">
                              <input type=\"text\" name=\"Name\" placeholder=\"Ваше имя...\">
                           </div>
                           <div class=\"forms-inputprod\">
                              <input class=\"phone_masckcom\" type=\"text\" name=\"Phone\" placeholder=\"Ваш телефон...\" required=\"\">
                           </div>
                           <div class=\"forms-inputprod\">
                              <button class=\"popup-a-button-form button-formprod\"><span>Отправить</span></button>
                           </div>
                        </form>
                        <div class=\"form-prodsec-text\">
                           <p>Мы прекрасно понимаем, что выбор отделочных материалов зачастую занимает много времени на поиск лучшего предложения по цене и качеству, предлагаем Вам получить действительно выгодное предложения и от нашей компании, т.к. мы являемся дилерами более чем от 50 брендов и можем предложить лучшие цены на продукцию, представленных на сайте производителей.</p><span>Нажимая кнопку \"Отправить\", вы даёте согласие на обработку ваших персональных данных</span>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            ";
        }
        // line 1109
        echo "      
      ";
        // line 1110
        if (($context["products"] ?? null)) {
            // line 1111
            echo "      <div class=\"container\">
         <div class=\"related-products\">
            <div class=\"text-title\">
               ";
            // line 1114
            if (($context["shadow_title"] ?? null)) {
                // line 1115
                echo "               <div class=\"shadow-title\">";
                echo ($context["text_buy_product"] ?? null);
                echo "</div>
               ";
            }
            // line 1117
            echo "               <div class=\"content-title\">";
            echo ($context["text_related"] ?? null);
            echo "</div>
            </div>
            <div class=\"catalog-section\">
               <div class=\"row no-gutters\">
                  ";
            // line 1121
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["products"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["product"]) {
                // line 1122
                echo "                  ";
                if ((twig_get_attribute($this->env, $this->source, $context["product"], "pmtemplate", [], "any", false, false, false, 1122) == "productdver")) {
                    // line 1123
                    echo "                  <div class=\"product-layout product-grid prodreldver col-xxl-2 col-lg-2 col-md-2 col-sm-4 col-4\">
                     ";
                } else {
                    // line 1125
                    echo "                     <div class=\"product-layout product-grid prodrelpol col-xxl-20 col-lg-2 col-md-3 col-sm-4 col-6\">
                        ";
                }
                // line 1127
                echo "                        <div class=\"product-item__container\">
                           <div class=\"product-item\">
                              <div class=\"product-item__image\">
                                 <a href=\"";
                // line 1130
                echo twig_get_attribute($this->env, $this->source, $context["product"], "href", [], "any", false, false, false, 1130);
                echo "\" class=\"product-image\">
                                    <img src=\"";
                // line 1131
                echo twig_get_attribute($this->env, $this->source, $context["product"], "thumb", [], "any", false, false, false, 1131);
                echo "\" alt=\"";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 1131);
                echo "\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 1131);
                echo "\"
                                       class=\"img-responsive\" />
                                 </a>
                                 <div class=\"product-item__icons\">
                                    <div class=\"product-item__delay\" data-toggle=\"tooltip\" title=\"";
                // line 1135
                echo ($context["button_wishlist"] ?? null);
                echo "\"
                                       onclick=\"wishlist.add('";
                // line 1136
                echo twig_get_attribute($this->env, $this->source, $context["product"], "product_id", [], "any", false, false, false, 1136);
                echo "');\">
                                       <i class=\"fi fi-rr-heart\"></i>
                                    </div>
                                 </div>
                              </div>
                              <div class=\"product-item__title\">
                                 <h3 class=\"product-item__heading\">
                                    <a href=\"";
                // line 1143
                echo twig_get_attribute($this->env, $this->source, $context["product"], "href", [], "any", false, false, false, 1143);
                echo "\"><span>";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 1143);
                echo "</span></a>
                                 </h3>
                              </div>
                              <div class=\"product-item__info\">
                                 <div class=\"product-item__caption-block\">
                                    <div class=\"product-item__caption\">
                                       <div class=\"product-item__blocks\">
                                          ";
                // line 1150
                if (twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 1150)) {
                    // line 1151
                    echo "                                          <div class=\"product-item__price\">
                                             ";
                    // line 1152
                    if ( !twig_get_attribute($this->env, $this->source, $context["product"], "special", [], "any", false, false, false, 1152)) {
                        // line 1153
                        echo "                                             <div class=\"product-price__main\">
                                                <span class=\"product-price__current\">";
                        // line 1154
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 1154);
                        if (twig_get_attribute($this->env, $this->source, $context["product"], "mpn", [], "any", false, false, false, 1154)) {
                            // line 1155
                            echo "                                                   за ";
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "mpn", [], "any", false, false, false, 1155);
                        }
                        echo "</span>
                                             </div>
                                             ";
                    } else {
                        // line 1158
                        echo "                                             <div class=\"product-price__main\">
                                                <span class=\"product-price__current price-new\">";
                        // line 1159
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "special", [], "any", false, false, false, 1159);
                        echo "</span>
                                             </div>
                                             <div class=\"product-item-price-stock\">
                                                <div class=\"product-item-price-old\">";
                        // line 1162
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 1162);
                        echo "</div>
                                                ";
                        // line 1163
                        if (twig_get_attribute($this->env, $this->source, $context["product"], "economy", [], "any", false, false, false, 1163)) {
                            // line 1164
                            echo "                                                <div class=\"product-item-price-economy\"> - ";
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "economy", [], "any", false, false, false, 1164);
                            echo "</div>
                                                ";
                        }
                        // line 1166
                        echo "                                             </div>
                                             ";
                    }
                    // line 1168
                    echo "                                          </div>
                                          ";
                }
                // line 1170
                echo "                                          ";
                if ((twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 1170) == false)) {
                    // line 1171
                    echo "                                          <div class=\"alert-price\">";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "attention", [], "any", false, false, false, 1171);
                    echo "</div>
                                          ";
                }
                // line 1173
                echo "                                          ";
                if (twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 1173)) {
                    // line 1174
                    echo "                                          ";
                    if ((twig_get_attribute($this->env, $this->source, $context["product"], "quantity", [], "any", false, false, false, 1174) <= 0)) {
                        echo " <div class=\"product-item__hidden\">
                                             <div class=\"product-item__quantity\">
                                                <i class=\"product-item__quantity-icon icon-danger\"></i>
                                                <span class=\"product-item__quantity-val\">";
                        // line 1177
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "stock", [], "any", false, false, false, 1177);
                        echo "</span>
                                             </div>
                                       </div>
                                       ";
                    } else {
                        // line 1181
                        echo "                                       <div class=\"product-item__hidden\">
                                          <div class=\"product-item__quantity\">
                                             <i class=\"product-item__quantity-icon icon-success\"></i>
                                             <span class=\"product-item__quantity-val\">";
                        // line 1184
                        echo ($context["text_instock"] ?? null);
                        echo "</span>
                                          </div>
                                       </div>
                                       ";
                    }
                    // line 1188
                    echo "                                       ";
                    if (($context["quantity_btn"] ?? null)) {
                        // line 1189
                        echo "                                       <div class=\"product-item__amount\">
                                          <button type=\"button\" aria-label=\"Button minus\"
                                             class=\"minus product-item__amount-btn-minus\">-</button>
                                          <input type=\"text\" name=\"quantity\" class=\"product-item__amount-input\" size=\"2\"
                                             value=\"";
                        // line 1193
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "minimum", [], "any", false, false, false, 1193);
                        echo "\" data-maximum=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "quantity", [], "any", false, false, false, 1193);
                        echo "\" />
                                          <button type=\"button\" aria-label=\"Button plus\"
                                             class=\"plus product-item__amount-btn-plus\">+</button>
                                       </div>
                                       ";
                    }
                    // line 1198
                    echo "                                       ";
                }
                // line 1199
                echo "                                    </div>
                                    <div class=\"product-button__container\">
                                       <button type=\"button\" class=\"btn btn-buy\"
                                          onclick=\"cart.add('";
                // line 1202
                echo twig_get_attribute($this->env, $this->source, $context["product"], "product_id", [], "any", false, false, false, 1202);
                echo "', \$(this).parent().parent().find('.product-item__amount-input').val());\"><span>";
                echo                 // line 1203
($context["button_cart"] ?? null);
                echo "</span></button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['product'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 1212
            echo "               </div>
            </div>
         </div>
      </div>
      ";
        }
        // line 1217
        echo "      </div>
      </section>
      </div>
<script>
\$(\"select[name='recurring_id'], input[name=\\\"quantity\\\"]\").change(function () {
\t\$.ajax({
\t\turl: \"index.php?route=product/product/getRecurringDescription\",
\t\ttype: \"post\",
\t\tdata: \$(\"input[name='product_id'], input[name='quantity'], select[name='recurring_id']\"),
\t\tdataType: \"json\",
\t\tbeforeSend: function () {
\t\t\t\$(\"#recurring-description\").html(\"\")
\t\t},
\t\tsuccess: function (a) {
\t\t\t\$(\".alert-dismissible, .text-danger\").remove();
\t\t\tif (a.success) {
\t\t\t\t\$(\"#recurring-description\").html(a.success)
\t\t\t}
\t\t}
\t})
});
</script> 
<script><!--
\$(\"#button-cart\").on(\"click\", function () {
\t\$.ajax({
\t\turl: \"index.php?route=checkout/cart/add\",
\t\ttype: \"post\",
\t\tdata: \$(\"#product input[type='text'], #product input[type='hidden'], #product input[type='radio']:checked, #product input[type='checkbox']:checked, #product select, #product textarea\"),
\t\tdataType: \"json\",
\t\tsuccess: function (b) {
\t\t\t\$(\".alert-dismissible, .text-danger\").remove();
\t\t\t\$(\".form-group\").removeClass(\"has-error\");
\t\t\tif (b.error) {
\t\t\t\tif (b.error[\"option\"]) {
\t\t\t\t\tfor (i in b.error[\"option\"]) {
\t\t\t\t\t\tvar a = \$(\"#input-option\" + i.replace(\"_\", \"-\"));
\t\t\t\t\t\tif (a.parent().hasClass(\"input-group\")) {
\t\t\t\t\t\t\ta.parent().after('<div class=\"text-danger\">' + b.error[\"option\"][i] + \"</div>\")
\t\t\t\t\t\t} else {
\t\t\t\t\t\t\ta.after('<div class=\"text-danger\">' + b.error[\"option\"][i] + \"</div>\")
\t\t\t\t\t\t}
\t\t\t\t\t}
\t\t\t\t\tvar options = \$('.product-options').offset().top - 300;\t\t\t\t
\t\t\t\t\t\$('html, body').animate({ scrollTop: options }, 'slow');
\t\t\t\t}
\t\t\t\tif (b.error[\"recurring\"]) {
\t\t\t\t\t\$(\"select[name='recurring_id']\").after('<div class=\"text-danger\">' + b.error[\"recurring\"] + \"</div>\")
\t\t\t\t}
\t\t\t\t\$(\".text-danger\").parent().addClass(\"has-error\")
\t\t\t}
\t\t\tif (b.success) {
\t\t\t\tsetTimeout(function () {
\t\t\t\t\t\$(\"body\").append('<div class=\"alert alert-top alert-cart alert-dismissible\"><i class=\"fi fi-rr-check\"></i>' + b.success + '<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button></div>');
\t\t\t\t\tif (window.innerWidth >= 992) {
\t\t\t\t\t\t\$(\".alert-top\").animate({
\t\t\t\t\t\t\ttop: 44
\t\t\t\t\t\t}, 500)
\t\t\t\t\t} else {
\t\t\t\t\t\t\$(\".alert-top\").animate({
\t\t\t\t\t\t\ttop: 0
\t\t\t\t\t\t}, 500)
\t\t\t\t\t}
\t\t\t\t}, 500);
\t\t\t\tsetTimeout(function () {
          \$(\".cart-count\").html(b.cart_total);
          \$('.panel-cart').removeClass('cart-empty');
\t\t\t\t}, 100);
\t\t\t\t\$(\"#button-cart\").addClass(\"add\");
\t\t\t\tsetTimeout(function () {
\t\t\t\t\t\$(\"#button-cart\").removeClass(\"add\")
\t\t\t\t}, 8000);
\t\t\t\t\$(\".cart-panel\").load(\"index.php?route=common/cart/info .cart-panel > *\")
\t\t\t}
\t\t},
\t\terror: function (c, a, b) {
\t\t\talert(b + \"\\r\\n\" + c.statusText + \"\\r\\n\" + c.responseText)
\t\t}
\t})
});
</script> 
<script><!--
\$(\".date\").datetimepicker({
\tlanguage: \"";
        // line 1299
        echo ($context["datepicker"] ?? null);
        echo "\",
\tpickTime: false
});
\$(\".datetime\").datetimepicker({
\tlanguage: \"";
        // line 1303
        echo ($context["datepicker"] ?? null);
        echo "\",
\tpickDate: true,
\tpickTime: true
});
\$(\".time\").datetimepicker({
\tlanguage: \"";
        // line 1308
        echo ($context["datepicker"] ?? null);
        echo "\",
\tpickDate: false
});
\$(\"button[id^='button-upload']\").on(\"click\", function () {
\tvar a = this;
\t\$(\"#form-upload\").remove();
\t\$(\"body\").prepend('<form enctype=\"multipart/form-data\" id=\"form-upload\" style=\"display: none;\"><input type=\"file\" name=\"file\" /></form>');
\t\$(\"#form-upload input[name='file']\").trigger(\"click\");
\tif (typeof timer != \"undefined\") {
\t\tclearInterval(timer)
\t}
\ttimer = setInterval(function () {
\t\tif (\$(\"#form-upload input[name='file']\").val() != \"\") {
\t\t\tclearInterval(timer);
\t\t\t\$.ajax({
\t\t\t\turl: \"index.php?route=tool/upload\",
\t\t\t\ttype: \"post\",
\t\t\t\tdataType: \"json\",
\t\t\t\tdata: new FormData(\$(\"#form-upload\")[0]),
\t\t\t\tcache: false,
\t\t\t\tcontentType: false,
\t\t\t\tprocessData: false,
\t\t\t\tbeforeSend: function () {
\t\t\t\t\t\$(a).button(\"loading\")
\t\t\t\t},
\t\t\t\tcomplete: function () {
\t\t\t\t\t\$(a).button(\"reset\")
\t\t\t\t},
\t\t\t\tsuccess: function (b) {
\t\t\t\t\t\$(\".text-danger\").remove();
\t\t\t\t\tif (b.error) {
\t\t\t\t\t\t\$(a).parent().find(\"input\").after('<div class=\"text-danger\">' + b.error + \"</div>\")
\t\t\t\t\t}
\t\t\t\t\tif (b.success) {
\t\t\t\t\t\talert(b.success);
\t\t\t\t\t\t\$(a).parent().find(\"input\").val(b.code)
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\terror: function (d, b, c) {
\t\t\t\t\talert(c + \"\\r\\n\" + d.statusText + \"\\r\\n\" + d.responseText)
\t\t\t\t}
\t\t\t})
\t\t}
\t}, 500)
});
//--></script> 
<script><!--
\$(\"#review\").delegate(\".pagination a\", \"click\", function (a) {
\ta.preventDefault();
\t\$(\"#review\").fadeOut(\"slow\");
\t\$(\"#review\").load(this.href);
\t\$(\"#review\").fadeIn(\"slow\")
});
\$(\"#review\").load(\"index.php?route=product/product/review&product_id=";
        // line 1361
        echo ($context["product_id"] ?? null);
        echo "\");
\$(\"#button-review\").on(\"click\", function () {
\t\$.ajax({
\t\turl: \"index.php?route=product/product/write&product_id=";
        // line 1364
        echo ($context["product_id"] ?? null);
        echo "\",
\t\ttype: \"post\",
\t\tdataType: \"json\",
\t\tdata: \$(\"#form-review\").serialize(),
\t\tbeforeSend: function () {
\t\t\t\$(\"#button-review\").button(\"loading\")
\t\t},
\t\tcomplete: function () {
\t\t\t\$(\"#button-review\").button(\"reset\")
\t\t},
\t\tsuccess: function (a) {
\t\t\t\$(\".alert-dismissible\").remove();
\t\t\tif (a.error) {
\t\t\t\t\$(\".form-review__card\").after('<div class=\"alert alert-danger alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ' + a.error + \"</div>\")
\t\t\t}
\t\t\tif (a.success) {
\t\t\t\t\$(\".form-review__card\").after('<div class=\"alert alert-success alert-dismissible\"><i class=\"fa fa-check-circle\"></i> ' + a.success + \"</div>\");
\t\t\t\t\$(\"input[name='name']\").val(\"\");
\t\t\t\t\$(\"textarea[name='text']\").val(\"\");
\t\t\t\t\$(\"input[name='rating']:checked\").prop(\"checked\", false)
\t\t\t}
\t\t}
\t})
});
\$(document).ready(function () {
\t\$(\".thumbnails\").magnificPopup({
\t\ttype: \"image\",
\t\tdelegate: \"a\",
\t\tgallery: {
\t\t\tenabled: true
\t\t}
\t})
});
//--></script>
<!--Marquiz script start--><!--<script src=\"//script.marquiz.ru/v1.js\"type=\"application/javascript\"></script><script>document.addEventListener(\"DOMContentLoaded\",function(){Marquiz.init({host:'//quiz.marquiz.ru',id:'5f4bc94f6622a70044cb1056',autoOpen:false,autoOpenFreq:'once',openOnExit:false})});</script>Marquiz script end--><!--<div class=\"marquiz-pops marquiz-pops_position_bottom-left marquiz-pops_rounded marquiz-pops_shadowed marquiz-pops_blicked marquiz-pops_position\"><a class=\"marquiz-pops__body\"href=\"#popup:marquiz_5f4bc94f6622a70044cb1056\"data-marquiz-pop-text-color=\"#ffffff\"data-marquiz-pop-background-color=\"#BA9160\"data-marquiz-pop-svg-color=\"#fff\"data-marquiz-pop-close-color=\"#fff\"data-marquiz-pop-color-pulse=\"rgba(186, 145, 96, 0.4)\"data-marquiz-pop-color-pulse-alpha=\"rgba(186, 145, 96, 0)\"data-marquiz-pop-bonuses=\"1\"data-marquiz-pop-delay=\"5s\"data-marquiz-pop=\"true\"><span class=\"marquiz-pops__icon\"></span><span class=\"marquiz-pops__content\"><span class=\"marquiz-pops__content-title\">Подобратьдвери</span><span class=\"marquiz-pops__content-text\">&laquo;Рассчитайтестоимостьвашихдверейиполучитескидку&raquo;</span></span><span class=\"marquiz-pops__bonus\">Вамдоступенбонусискидка</span></a></div><script>function jivo_onLoadCallback(){jivo_config.rules=[{\"conditions\":[{\"condition\":\"time_on_site\",\"comparator\":\"greater\",\"value\":50},{\"condition\":\"time_after_close\",\"comparator\":\"greater\",\"value\":500}],\"commands\":[{\"command\":\"proactive\",\"params\":{\"message\":\"Сейчас действует специальное предложение на ";
        // line 1398
        echo ($context["heading_title"] ?? null);
        echo ", если хотите узнать подробнее - напишите нам или оставьте контактный номер. Наши менеджеры Вам все расскажут ;)\"}}],\"name\":\"Proactive Invitation on Every Page\",\"enabled\":true,\"type\":\"all\"},{\"name\":\"Lead Collection When Agents are Offline\",\"enabled\":true,\"type\":\"all\",\"conditions\":[{\"condition\":\"online\",\"value\":false},{\"condition\":\"time_on_page\",\"comparator\":\"greater\",\"value\":10},{\"condition\":\"time_on_site\",\"comparator\":\"greater\",\"value\":20},{\"condition\":\"time_after_close\",\"comparator\":\"greater\",\"value\":300},{\"condition\":\"time_after_invitation\",\"comparator\":\"greater\",\"value\":60}],\"commands\":[{\"command\":\"open_offline\",\"params\":{\"title\":\"Отправьте нам сообщение\",\"message\":\"Здравствуйте. \\nУ вас возникли вопросы? Мы с удовольствием ответим!\"}}]},{\"name\":\"Retaining Message if Agent is not Answering\",\"enabled\":true,\"type\":\"all\",\"conditions\":[{\"condition\":\"online\",\"value\":true},{\"condition\":\"time_after_first_message\",\"comparator\":\"greater\",\"value\":60}],\"commands\":[{\"command\":\"system_message\",\"params\":{\"message\":\"Пожалуйста, подождите. Сейчас операторы заняты, но скоро кто-нибудь освободится и ответит вам!\"}}]}]}</script>-->
<script>
   \$(document).ready(function () {
      \$(\"#forma-podpred\").submit(function () {
         var th = \$(this);
         \$.ajax({
            type: \"POST\",
            url: \"mail.php\",
            data: th.serialize()
         }).done(function () {
            alert(\"Благодарим за заявку!\");
            setTimeout(function () {
               // Done Functions
               th.trigger(\"reset\");
            }, 1000);
         });
         return false;
      });
   });
   \$(document).ready(function() {
     \$(\".ajax-form-mail\").submit(function() {
       var th = \$(this);
       \$.ajax({
         type: \"POST\",
         url: \"mail.php\",
         data: th.serialize()
       }).done(function() {
         alert(\"Благодарим за заявку!\");
         setTimeout(function() {
           // Done Functions
           th.trigger(\"reset\");
         }, 1000);
       });
       return false;
     });
   });
   </script>

   <script>
      \$(document).ready(function(){
         \$('#interior-first').click(function () {
           \$('#bg-inter-change').addClass('interior-form-bg-first');
           \$('#bg-inter-change').removeClass('interior-form-bg-second');
           \$('#bg-inter-change').removeClass('interior-form-bg-three');
           \$('#bg-inter-change').removeClass('interior-form-four');
           \$('#bg-inter-change').removeClass('interior-form-five');
           \$('#bg-inter-change').removeClass('interior-form-six');
         });
         \$('#interior-second').click(function () {
           \$('#bg-inter-change').removeClass('interior-form-bg-first');
           \$('#bg-inter-change').addClass('interior-form-bg-second');
           \$('#bg-inter-change').removeClass('interior-form-bg-three');
           \$('#bg-inter-change').removeClass('interior-form-four');
           \$('#bg-inter-change').removeClass('interior-form-five');
           \$('#bg-inter-change').removeClass('interior-form-six');
         });
         \$('#interior-three').click(function () {
           \$('#bg-inter-change').removeClass('interior-form-bg-first');
           \$('#bg-inter-change').removeClass('interior-form-bg-second');
           \$('#bg-inter-change').addClass('interior-form-bg-three');
           \$('#bg-inter-change').removeClass('interior-form-four');
           \$('#bg-inter-change').removeClass('interior-form-five');
           \$('#bg-inter-change').removeClass('interior-form-six');
         });
         \$('#interior-four').click(function () {
           \$('#bg-inter-change').removeClass('interior-form-bg-first');
           \$('#bg-inter-change').removeClass('interior-form-bg-second');
           \$('#bg-inter-change').removeClass('interior-form-bg-three');
           \$('#bg-inter-change').addClass('interior-form-four');
           \$('#bg-inter-change').removeClass('interior-form-five');
           \$('#bg-inter-change').removeClass('interior-form-six');
         });
         \$('#interior-five').click(function () {
           \$('#bg-inter-change').removeClass('interior-form-bg-first');
           \$('#bg-inter-change').removeClass('interior-form-bg-second');
           \$('#bg-inter-change').removeClass('interior-form-bg-three');
           \$('#bg-inter-change').removeClass('interior-form-four');
           \$('#bg-inter-change').addClass('interior-form-five');
           \$('#bg-inter-change').removeClass('interior-form-six');
         });
         \$('#interior-six').click(function () {
           \$('#bg-inter-change').removeClass('interior-form-bg-first');
           \$('#bg-inter-change').removeClass('interior-form-bg-second');
           \$('#bg-inter-change').removeClass('interior-form-bg-three');
           \$('#bg-inter-change').removeClass('interior-form-four');
           \$('#bg-inter-change').removeClass('interior-form-five');
           \$('#bg-inter-change').addClass('interior-form-six');
         });
       });
      // Кнопки Minus Click
      \$( \"#minus-input-calc, #minus-input-calc2\" ).click(function() {
         let factkolvoup = \$('#kolvopachek').val();
         caaaalcminus(factkolvoup);
       });
       // Кнопки Plus Click
       \$( \"#plus-input-calc, #plus-input-calc2\" ).click(function() {
          let factkolvoup = \$('#kolvopachek').val();
          caaaalcplus(factkolvoup);
        });
        <!-- Изменения в поле упаковок -->
        \$( \"#kolvopachek\" ).change(function() {
         let factkolvoup = \$('#kolvopachek').val();
         caaaalcinputup(factkolvoup);
       });
        <!-- Изменения в поле метража-->
        \$( \"#chislo\" ).change(function() {
         let factkolvoup = \$('#chislo').val();
         caaaalcinputmetraj(factkolvoup);
       });
      // Общие переменные

         var metraj = \$('#chislo').val();
         var pricenoskid = \$('#chislo').attr('pricemain');
         var priceed = parseInt(\$('#chislo').attr('priceskidk'));
         var skidkar = \$('#chislo').attr('skidkatrue');
         
      // Работа по вводу в инпут
         function caaaalcinputup(summcalcin){
            <!-- Логика -->
            let pachkasht = Math.ceil(parseFloat(summcalcin).toFixed(2))
            vyvodinput(pachkasht);
         }
         function caaaalcinputmetraj(summcalcin){
            <!-- Логика -->
            let metrajvalid = summcalcin / metraj
            let pachkasht = Math.ceil(parseFloat(metrajvalid).toFixed(2))
            vyvodinput(pachkasht);
         }
      // Работа по кнопкам
         function caaaalcminus(summcalcin){
            <!-- Логика -->
            let pluspachk = parseFloat(summcalcin).toFixed(2)
            let finalValue = parseInt(pluspachk) - 1
            vyvodinput(finalValue);
         }
         function caaaalcplus(summcalcin){
            <!-- Логика -->
            let pluspachk = parseFloat(summcalcin).toFixed(2)
            let finalValue = parseInt(pluspachk) + 1
            vyvodinput(finalValue);
         }
      // Вывод значений в инпуте
         function vyvodinput(final_upak){
            var input_id = '#kolvopachek';
            var input_metraj = '#chislo';
            let proverka = parseInt(final_upak)
            let metrajitog = parseFloat(proverka * metraj).toFixed(3)
         // Проверка на единицу
            if(proverka > 1000) {
               let calcpromup = 1000;
               let calcprommetr = metraj * calcpromup;
               vyvodinputtwo(calcpromup,calcprommetr);
            } else if(proverka > 1) {
               let calcpromup = proverka;
               let calcprommetr = metrajitog;
               vyvodinputtwo(calcpromup,calcprommetr);
            } else {
               let calcpromup = 1;
               let calcprommetr = metraj;
               vyvodinputtwo(calcpromup,calcprommetr);
            }
         // Вывод в поля калькулятора
            function vyvodinputtwo(calcprup,calcprmetr){
               \$(input_id).val(calcprup);
               \$(input_metraj).val(calcprmetr);
               \$('#input-quantity').attr('value', calcprmetr);

               function declination(number, titles) {
                  cases = [2, 0, 1, 1, 1, 2];
                  return titles[ (number%100>4 && number%100<20)? 2:cases
                     [(number%10<5)?number%10:5] ];
               }
               let title = declination(calcprup, [' упаковка', ' упаковки', ' упаковок']);
               let pricesumm = parseInt(calcprmetr * priceed)
               let priceskidka = parseInt(pricenoskid - priceed)
               let pricesmbezskidk = parseInt(calcprmetr * pricenoskid)
               let pricesumskidk = parseInt(priceskidka * calcprmetr)
               if(skidkar == '1') {
                  let textoffer = '<p class=\"double-info-stoimost\">'
                     + calcprup
                     + ' '
                     + title
                     + ' ('
                     +  calcprmetr
                     + 'м<sup>2</sup>)</p>'
                     + '<p class=\"clcnoskdksm\"><span class=\"prclc-snsk\">Сумма без скидки: '
                     + pricesmbezskidk
                     + ' р.</span></p>'
                     + '<p class=\"clcsmckd\">Скидка: <span class=\"razmskidk\">'
                     + pricesumskidk
                     + 'р. </span></p><p class=\"items-stoimost\">Общая стоимость: '
                     + pricesumm
                     + ' руб.</p>';
                  \$('#resultcalcflo').html(textoffer);
               } else {
                  let textoffer = '<p class=\"double-info-stoimost\">'
                     + calcprup
                     + ' '
                     + title
                     + ' ('
                     +  calcprmetr
                     + 'м<sup>2</sup>)</p>'
                     + '<p class=\"items-stoimost\">Общая стоимость: '
                     + pricesumm
                     + ' руб.</p>';
                  \$('#resultcalcflo').html(textoffer);
               }
               
            }
         }
    </script>
";
        // line 1609
        echo ($context["footer"] ?? null);
    }

    public function getTemplateName()
    {
        return "stroimarket/template/product/product.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  2887 => 1609,  2673 => 1398,  2636 => 1364,  2630 => 1361,  2574 => 1308,  2566 => 1303,  2559 => 1299,  2475 => 1217,  2468 => 1212,  2453 => 1203,  2450 => 1202,  2445 => 1199,  2442 => 1198,  2432 => 1193,  2426 => 1189,  2423 => 1188,  2416 => 1184,  2411 => 1181,  2404 => 1177,  2397 => 1174,  2394 => 1173,  2388 => 1171,  2385 => 1170,  2381 => 1168,  2377 => 1166,  2371 => 1164,  2369 => 1163,  2365 => 1162,  2359 => 1159,  2356 => 1158,  2348 => 1155,  2345 => 1154,  2342 => 1153,  2340 => 1152,  2337 => 1151,  2335 => 1150,  2323 => 1143,  2313 => 1136,  2309 => 1135,  2298 => 1131,  2294 => 1130,  2289 => 1127,  2285 => 1125,  2281 => 1123,  2278 => 1122,  2274 => 1121,  2266 => 1117,  2260 => 1115,  2258 => 1114,  2253 => 1111,  2251 => 1110,  2248 => 1109,  2225 => 1089,  2214 => 1080,  2211 => 1079,  2183 => 1054,  2134 => 1016,  2128 => 1013,  2055 => 943,  2016 => 906,  2014 => 905,  2010 => 903,  2005 => 900,  1999 => 899,  1991 => 897,  1983 => 895,  1980 => 894,  1976 => 893,  1971 => 891,  1968 => 890,  1966 => 889,  1962 => 887,  1952 => 879,  1946 => 877,  1941 => 875,  1934 => 873,  1925 => 867,  1918 => 863,  1913 => 861,  1903 => 854,  1899 => 853,  1895 => 852,  1891 => 851,  1887 => 850,  1877 => 843,  1869 => 842,  1863 => 838,  1861 => 837,  1854 => 833,  1850 => 832,  1838 => 823,  1834 => 822,  1830 => 820,  1827 => 819,  1823 => 817,  1786 => 782,  1783 => 781,  1746 => 746,  1743 => 745,  1682 => 686,  1680 => 685,  1677 => 684,  1671 => 683,  1662 => 680,  1658 => 679,  1655 => 678,  1650 => 677,  1646 => 676,  1643 => 675,  1641 => 674,  1636 => 671,  1633 => 670,  1627 => 669,  1620 => 665,  1615 => 664,  1612 => 663,  1607 => 662,  1604 => 661,  1601 => 660,  1595 => 659,  1588 => 655,  1583 => 654,  1580 => 653,  1575 => 652,  1573 => 651,  1568 => 649,  1563 => 647,  1560 => 646,  1556 => 644,  1550 => 643,  1542 => 640,  1536 => 639,  1532 => 638,  1528 => 637,  1523 => 636,  1520 => 635,  1516 => 634,  1511 => 633,  1509 => 632,  1504 => 630,  1499 => 627,  1495 => 625,  1492 => 624,  1486 => 620,  1483 => 619,  1477 => 617,  1474 => 616,  1468 => 614,  1466 => 613,  1462 => 612,  1453 => 605,  1442 => 596,  1434 => 590,  1432 => 589,  1378 => 537,  1374 => 535,  1370 => 533,  1368 => 532,  1365 => 531,  1340 => 509,  1333 => 505,  1329 => 504,  1324 => 502,  1321 => 501,  1318 => 500,  1305 => 490,  1299 => 489,  1294 => 487,  1291 => 486,  1288 => 485,  1284 => 483,  1282 => 482,  1278 => 480,  1268 => 473,  1264 => 472,  1260 => 471,  1224 => 438,  1216 => 433,  1205 => 424,  1203 => 423,  1199 => 421,  1195 => 419,  1192 => 418,  1182 => 415,  1177 => 414,  1171 => 412,  1168 => 411,  1162 => 409,  1160 => 408,  1157 => 407,  1154 => 406,  1150 => 404,  1136 => 400,  1129 => 398,  1126 => 397,  1122 => 396,  1116 => 394,  1113 => 393,  1110 => 392,  1104 => 390,  1101 => 389,  1096 => 386,  1088 => 384,  1085 => 383,  1077 => 381,  1074 => 380,  1065 => 378,  1062 => 377,  1056 => 375,  1054 => 374,  1050 => 373,  1047 => 372,  1037 => 370,  1035 => 369,  1031 => 367,  1028 => 366,  1022 => 364,  1020 => 363,  997 => 345,  993 => 344,  980 => 334,  974 => 333,  968 => 332,  962 => 328,  957 => 325,  951 => 323,  942 => 320,  937 => 318,  933 => 316,  928 => 315,  925 => 314,  916 => 310,  910 => 307,  906 => 305,  904 => 304,  899 => 302,  896 => 301,  893 => 300,  891 => 299,  886 => 296,  880 => 292,  869 => 290,  865 => 289,  861 => 288,  855 => 285,  852 => 284,  849 => 283,  845 => 281,  839 => 280,  825 => 273,  818 => 271,  811 => 270,  808 => 269,  794 => 262,  787 => 260,  780 => 259,  777 => 258,  763 => 251,  756 => 249,  749 => 248,  746 => 247,  738 => 244,  730 => 243,  726 => 242,  719 => 241,  716 => 240,  704 => 237,  698 => 236,  691 => 235,  688 => 234,  676 => 231,  670 => 230,  663 => 229,  660 => 228,  655 => 225,  646 => 221,  638 => 219,  625 => 218,  611 => 216,  609 => 215,  605 => 214,  597 => 213,  594 => 212,  590 => 211,  586 => 210,  582 => 209,  575 => 208,  572 => 207,  567 => 204,  558 => 200,  550 => 198,  537 => 197,  523 => 195,  521 => 194,  517 => 193,  509 => 192,  506 => 191,  502 => 190,  498 => 189,  494 => 188,  487 => 187,  484 => 186,  479 => 183,  471 => 180,  464 => 179,  462 => 178,  455 => 177,  451 => 176,  447 => 175,  441 => 174,  435 => 173,  428 => 172,  425 => 171,  421 => 170,  418 => 169,  416 => 168,  407 => 161,  385 => 157,  381 => 156,  376 => 155,  372 => 154,  370 => 153,  363 => 148,  359 => 146,  355 => 144,  353 => 143,  345 => 137,  296 => 90,  294 => 89,  287 => 84,  283 => 82,  280 => 81,  263 => 79,  258 => 78,  255 => 77,  241 => 75,  239 => 74,  229 => 66,  225 => 64,  219 => 63,  203 => 60,  198 => 59,  195 => 58,  191 => 57,  186 => 56,  184 => 55,  179 => 52,  175 => 50,  169 => 49,  153 => 46,  148 => 45,  145 => 44,  141 => 43,  136 => 42,  134 => 41,  129 => 38,  127 => 37,  122 => 34,  118 => 32,  114 => 30,  112 => 29,  105 => 25,  100 => 24,  94 => 22,  92 => 21,  88 => 19,  82 => 17,  80 => 16,  76 => 14,  69 => 13,  63 => 12,  55 => 10,  53 => 9,  47 => 8,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "stroimarket/template/product/product.twig", "");
    }
}

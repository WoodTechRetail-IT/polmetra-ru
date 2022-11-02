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

/* stroimarket/template/product/category.twig */
class __TwigTemplate_45622ba2c12a7558565e9203ae970ca7172ee06dab443ce475af0e07e0dafc8b extends \Twig\Template
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
<div id=\"product-category\" class=\"full-layout\">
  <div class=\"bg-container\">
    <div class=\"container\">
      <div class=\"navigation-content\">
        <ul class=\"breadcrumb\">
          ";
        // line 7
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["i"] => $context["breadcrumb"]) {
            echo " 
          ";
            // line 8
            if ((($context["i"] + 1) < twig_length_filter($this->env, ($context["breadcrumbs"] ?? null)))) {
                // line 9
                echo "          <li><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 9);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 9);
                echo "</a></li>
          ";
            } else {
                // line 11
                echo "          <li>";
                echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 11);
                echo "</li>
          ";
            }
            // line 12
            echo " 
          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['i'], $context['breadcrumb'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "\t
        </ul>
      </div>
      <div class=\"navigation-title\">
        <h1>";
        // line 17
        echo ($context["heading_title"] ?? null);
        echo "</h1>
      </div>
    </div>
  </div>
  <div class=\"catalog-product__block catalog-section__products\">
    <div class=\"container\">
      <div class=\"catalog-section\">
        <div class=\"row\">
          ";
        // line 25
        echo ($context["column_left"] ?? null);
        echo "
          ";
        // line 26
        if ((($context["column_left"] ?? null) && ($context["column_right"] ?? null))) {
            // line 27
            echo "          ";
            $context["class"] = "col-sm-6";
            // line 28
            echo "          ";
        } elseif ((($context["column_left"] ?? null) || ($context["column_right"] ?? null))) {
            // line 29
            echo "          ";
            $context["class"] = "col-sm-9";
            // line 30
            echo "          ";
        } else {
            // line 31
            echo "          ";
            $context["class"] = "col-sm-12";
            // line 32
            echo "          ";
        }
        // line 33
        echo "          <div id=\"content\" class=\"";
        echo ($context["class"] ?? null);
        echo "\">
            <div class=\"catalog-section__container\">
              ";
        // line 35
        echo ($context["content_top"] ?? null);
        echo "\t\t    
              <!--";
        // line 36
        if (($context["banner"] ?? null)) {
            // line 37
            echo "              <div class=\"category-banner\">
                <div class=\"category-banner__full\">
                  <img src=\"";
            // line 39
            echo ($context["banner"] ?? null);
            echo "\" alt=\"";
            echo ($context["heading_title"] ?? null);
            echo "\" title=\"";
            echo ($context["heading_title"] ?? null);
            echo "\" class=\"img-responsive\" />
                </div>
              </div>
              ";
        }
        // line 42
        echo "-->
              ";
        // line 43
        if (($context["categories"] ?? null)) {
            // line 44
            echo "              <div class=\"catalog-section__list catalog-sections ogranichitel\">
              
              
                 ";
            // line 47
            if ((($context["noviewchild"] ?? null) == "0")) {
                // line 48
                echo "                            <div class=\"row\">
                              ";
                // line 49
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["categories"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
                    // line 50
                    echo "                                  <div class=\"col-sm-6 col-md-3 col-lg-2 col-xxl-20 ogranichitel-dve\">
                                        <!--<a class=\"catalog-section__item ";
                    // line 51
                    if (twig_get_attribute($this->env, $this->source, $context["category"], "thumb", [], "any", false, false, false, 51)) {
                        echo "has-image";
                    }
                    echo "\" href=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["category"], "href", [], "any", false, false, false, 51);
                    echo "\" title=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["category"], "href", [], "any", false, false, false, 51);
                    echo "\">-->
                                        <a class=\"catalog-section__item\" href=\"";
                    // line 52
                    echo twig_get_attribute($this->env, $this->source, $context["category"], "href", [], "any", false, false, false, 52);
                    echo "\" title=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["category"], "href", [], "any", false, false, false, 52);
                    echo "\">
                                          ";
                    // line 53
                    if (twig_get_attribute($this->env, $this->source, $context["category"], "config_count", [], "any", false, false, false, 53)) {
                        // line 54
                        echo "                                          <span class=\"catalog-section__item__count\">";
                        echo twig_get_attribute($this->env, $this->source, $context["category"], "count", [], "any", false, false, false, 54);
                        echo "</span>
                                          ";
                    }
                    // line 56
                    echo "                                          ";
                    if (twig_get_attribute($this->env, $this->source, $context["category"], "thumb", [], "any", false, false, false, 56)) {
                        // line 57
                        echo "                                          <!--<span class=\"catalog-section-item__image\">
                                            <img src=\"";
                        // line 58
                        echo twig_get_attribute($this->env, $this->source, $context["category"], "thumb", [], "any", false, false, false, 58);
                        echo "\" alt=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 58);
                        echo "\" title=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 58);
                        echo "\" class=\"img-responsive\" />
                                          </span>-->
                                          ";
                    }
                    // line 61
                    echo "                                          <span class=\"catalog-section__item__title\">";
                    echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 61);
                    echo "</span>
                                        </a>
                                      </div>
                                  ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 64
                echo "\t\t\t\t
                                </div>
                 ";
            } elseif ((            // line 66
($context["noviewchild"] ?? null) == "1")) {
                // line 67
                echo "                            <div class=\"row\">\t\t\t\t
                            </div>
                ";
            }
            // line 70
            echo "              </div>
              ";
        }
        // line 72
        echo "              ";
        if (($context["products"] ?? null)) {
            // line 73
            echo "              <div class=\"catalog-toolbar__sort\">
                <div class=\"catalog-toolbar__panel d-flex align-items-center\">
                  <div class=\"toolbar-form__input\">
                    <div class=\"toolbar-form__sort\">
                      <select id=\"input-sort\" class=\"form-control form-control-sm\" onchange=\"location = this.value;\">
                        ";
            // line 78
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["sorts"]);
            foreach ($context['_seq'] as $context["_key"] => $context["sorts"]) {
                // line 79
                echo "                        ";
                if ((twig_get_attribute($this->env, $this->source, $context["sorts"], "value", [], "any", false, false, false, 79) == sprintf("%s-%s", ($context["sort"] ?? null), ($context["order"] ?? null)))) {
                    // line 80
                    echo "                        <option value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["sorts"], "href", [], "any", false, false, false, 80);
                    echo "\" selected=\"selected\">";
                    echo twig_get_attribute($this->env, $this->source, $context["sorts"], "text", [], "any", false, false, false, 80);
                    echo "</option>
                        ";
                } else {
                    // line 82
                    echo "                        <option value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["sorts"], "href", [], "any", false, false, false, 82);
                    echo "\">";
                    echo twig_get_attribute($this->env, $this->source, $context["sorts"], "text", [], "any", false, false, false, 82);
                    echo "</option>
                        ";
                }
                // line 84
                echo "                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sorts'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 85
            echo "                      </select>
                    </div>
                  </div>
                  <div class=\"toolbar-form__input\">
                    <div class=\"toolbar-form__limit\">
                      <select id=\"input-limit\" class=\"form-control form-control-sm\" onchange=\"location = this.value;\">
                        ";
            // line 91
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["limits"]);
            foreach ($context['_seq'] as $context["_key"] => $context["limits"]) {
                // line 92
                echo "                        ";
                if ((twig_get_attribute($this->env, $this->source, $context["limits"], "value", [], "any", false, false, false, 92) == ($context["limit"] ?? null))) {
                    // line 93
                    echo "                        <option value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["limits"], "href", [], "any", false, false, false, 93);
                    echo "\" selected=\"selected\">";
                    echo twig_get_attribute($this->env, $this->source, $context["limits"], "text", [], "any", false, false, false, 93);
                    echo "</option>
                        ";
                } else {
                    // line 95
                    echo "                        <option value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["limits"], "href", [], "any", false, false, false, 95);
                    echo "\">";
                    echo twig_get_attribute($this->env, $this->source, $context["limits"], "text", [], "any", false, false, false, 95);
                    echo "</option>
                        ";
                }
                // line 97
                echo "                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['limits'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 98
            echo "                      </select>
                    </div>
                  </div>
                  <div class=\"toolbar-form__toggle hidden-xs hidden-sm text-right ml-auto\">
                    <div class=\"toolbar-toggle d-flex align-items-center\">
                      <button type=\"button\" id=\"grid-view\" class=\"grid-view clear-button\" title=\"";
            // line 103
            echo ($context["button_grid"] ?? null);
            echo "\"></button>
                      <button type=\"button\" id=\"list-view\" class=\"list-view clear-button\" title=\"";
            // line 104
            echo ($context["button_list"] ?? null);
            echo "\"></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class=\"catalog-section\">
                <div class=\"row no-gutters\">
                  ";
            // line 111
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["products"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["product"]) {
                // line 112
                echo "                  
                  
                    ";
                // line 114
                if ((twig_get_attribute($this->env, $this->source, $context["product"], "pmtemplate", [], "any", false, false, false, 114) == "productpol")) {
                    // line 115
                    echo "                    
                  
                      <div class=\"product-layout product-list col-12\">
                        <div class=\"product-item__container product-thumb\">
                          <div class=\"product-item itemprodpol\">
\t\t\t\t\t<!-- XD stickers start -->
\t\t\t\t\t";
                    // line 121
                    if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["product"], "product_xdstickers", [], "any", false, false, false, 121))) {
                        // line 122
                        echo "\t\t\t\t\t<div class=\"xdstickers_wrapper clearfix ";
                        echo ($context["xdstickers_position"] ?? null);
                        echo "\">
\t\t\t\t\t\t";
                        // line 123
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["product"], "product_xdstickers", [], "any", false, false, false, 123));
                        foreach ($context['_seq'] as $context["_key"] => $context["xdsticker"]) {
                            // line 124
                            echo "\t\t\t\t\t        ";
                            if ((twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 124) == "left")) {
                                // line 125
                                echo "\t\t\t\t\t\t\t<div class=\"xdstickers ";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 125);
                                echo "\">
\t\t\t\t\t\t\t\t<div class=\"xdstickerbackground xdstickid";
                                // line 126
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 126);
                                echo "\" data-html=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 126);
                                echo "\" style=\"background-image: url('/";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "imagestick", [], "any", false, false, false, 126);
                                echo "');\" alt=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 126);
                                echo "\" datatyp=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "typet", [], "any", false, false, false, 126);
                                echo "\" datatwo=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 126);
                                echo "\"></div>
\t\t\t\t\t\t\t</div>
                              ";
                            }
                            // line 129
                            echo "                              
\t\t\t\t\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['xdsticker'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 131
                        echo "\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"xdstickers_wrapper clearfix xdright-two ";
                        // line 132
                        echo ($context["xdstickers_position"] ?? null);
                        echo "\">
\t\t\t\t\t\t";
                        // line 133
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["product"], "product_xdstickers", [], "any", false, false, false, 133));
                        foreach ($context['_seq'] as $context["_key"] => $context["xdsticker"]) {
                            // line 134
                            echo "\t\t\t\t\t        ";
                            if ((twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 134) == "right")) {
                                // line 135
                                echo "\t\t\t\t\t\t\t<div class=\"xdstickers ";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 135);
                                echo "\">
\t\t\t\t\t\t\t\t<div class=\"xdstickerbackground xdstickid";
                                // line 136
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 136);
                                echo "\" data-html=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 136);
                                echo "\" style=\"background-image: url('/";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "imagestick", [], "any", false, false, false, 136);
                                echo "');\" alt=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 136);
                                echo "\" datatyp=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "typet", [], "any", false, false, false, 136);
                                echo "\" datatwo=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 136);
                                echo "\"></div>
\t\t\t\t\t\t\t</div>
                              ";
                            }
                            // line 139
                            echo "                              
\t\t\t\t\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['xdsticker'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 141
                        echo "\t\t\t\t\t</div>
\t\t\t\t\t";
                    }
                    // line 143
                    echo "\t\t\t\t\t<!-- XD stickers end -->
                            <div class=\"product-item__image image\">
                                  <a href=\"";
                    // line 145
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "href", [], "any", false, false, false, 145);
                    echo "\" class=\"product-image\">
                                    <img src=\"";
                    // line 146
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "thumb", [], "any", false, false, false, 146);
                    echo "\" alt=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 146);
                    echo "\" title=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 146);
                    echo "\" class=\"img-responsive\" />\t\t
                                    ";
                    // line 147
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "percent", [], "any", false, false, false, 147)) {
                        // line 148
                        echo "                                    <div class=\"product-item-markers product-item-markers-icons\">
                                      <span class=\"product-item-marker-container product-item-marker-container-hidden\">
                                        <span class=\"product-item-marker product-item-marker-discount product-item-marker-14px\"><span>";
                        // line 150
                        echo (("-" . twig_get_attribute($this->env, $this->source, $context["product"], "percent", [], "any", false, false, false, 150)) . "%");
                        echo "</span></span>
                                      </span>
                                    </div>
                                    ";
                    }
                    // line 154
                    echo "                                  </a>
                                  <div class=\"product-item__icons\">
                                    <div class=\"product-item__delay\" data-toggle=\"tooltip\" title=\"";
                    // line 156
                    echo ($context["button_wishlist"] ?? null);
                    echo "\" onclick=\"wishlist.add('";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "product_id", [], "any", false, false, false, 156);
                    echo "');\">
                                      <i class=\"fi fi-rr-heart\"></i>
                                    </div>
                                  </div>
                                  ";
                    // line 160
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer_image", [], "any", false, false, false, 160)) {
                        // line 161
                        echo "                                  <div class=\"product-item__brand\">
                                    <img src=\"";
                        // line 162
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer_image", [], "any", false, false, false, 162);
                        echo "\" alt=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer", [], "any", false, false, false, 162);
                        echo "\" title=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer", [], "any", false, false, false, 162);
                        echo "\">
                                  </div>
                                  ";
                    }
                    // line 165
                    echo "                            </div>
                            <div class=\"product-item__basket caption product-item__basket-pol\">
                              ";
                    // line 167
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "sku", [], "any", false, false, false, 167)) {
                        // line 168
                        echo "                              <div class=\"product-item__sku\">
                                <span class=\"product-item__text_sku\">";
                        // line 169
                        echo ($context["text_sku"] ?? null);
                        echo " ";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "sku", [], "any", false, false, false, 169);
                        echo "</span>
                              </div>
                              ";
                    }
                    // line 172
                    echo "                              <div class=\"product-item__title\">
                                <h3 class=\"product-item__heading\">
                                  <a href=\"";
                    // line 174
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "href", [], "any", false, false, false, 174);
                    echo "\"><span>";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 174);
                    echo "</span></a>
                                </h3>
                                ";
                    // line 176
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "hpm_block", [], "any", false, false, false, 176)) {
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "hpm_block", [], "any", false, false, false, 176);
                    }
                    // line 177
                    echo "                              </div>
                              <div>
                                ";
                    // line 179
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "attribute_groups", [], "any", false, false, false, 179)) {
                        // line 180
                        echo "                                ";
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["product"], "attribute_groups", [], "any", false, false, false, 180));
                        foreach ($context['_seq'] as $context["_key"] => $context["attribute_group"]) {
                            // line 181
                            echo "                                ";
                            $context['_parent'] = $context;
                            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["attribute_group"], "attribute", [], "any", false, false, false, 181));
                            foreach ($context['_seq'] as $context["_key"] => $context["attribute"]) {
                                // line 182
                                echo "                                ";
                                if (twig_in_filter(twig_get_attribute($this->env, $this->source, $context["attribute"], "attribute_id", [], "any", false, false, false, 182), [0 => 2509, 1 => 167, 2 => 2242, 3 => 2163, 4 => 2160, 5 => 2164, 6 => 2163, 7 => 2161])) {
                                    // line 183
                                    echo "                                <div>";
                                    echo twig_get_attribute($this->env, $this->source, $context["attribute"], "text", [], "any", false, false, false, 183);
                                    echo "</div>
                                ";
                                }
                                // line 185
                                echo "                                ";
                            }
                            $_parent = $context['_parent'];
                            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attribute'], $context['_parent'], $context['loop']);
                            $context = array_intersect_key($context, $_parent) + $_parent;
                            // line 186
                            echo "                                ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attribute_group'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 187
                        echo "                                ";
                    }
                    echo "  
                              </div>
                              <div class=\"product-item__info\">
                                <div class=\"product-item__caption-block\">
                                  <div class=\"product-item__caption\">
                                    <div class=\"product-item__blocks\">
                                      ";
                    // line 193
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 193)) {
                        // line 194
                        echo "                                      <div class=\"product-item__price\">
                                        ";
                        // line 195
                        if ( !twig_get_attribute($this->env, $this->source, $context["product"], "special", [], "any", false, false, false, 195)) {
                            // line 196
                            echo "                                        <div class=\"product-price__main\">
                                          <span class=\"product-price__current\">";
                            // line 197
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 197);
                            echo " за ";
                            echo ($context["text_mpn"] ?? null);
                            echo " ";
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "mpn", [], "any", false, false, false, 197);
                            echo "</span>
                                        </div>
                                        ";
                        } else {
                            // line 200
                            echo "                                        <div class=\"product-item-price-stock\">
                                          <div class=\"product-item-price-old\">";
                            // line 201
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 201);
                            echo "</div>
                                          ";
                            // line 202
                            if (twig_get_attribute($this->env, $this->source, $context["product"], "economy", [], "any", false, false, false, 202)) {
                                // line 203
                                echo "                                          <div class=\"product-item-price-economy\"> - ";
                                echo twig_get_attribute($this->env, $this->source, $context["product"], "economy", [], "any", false, false, false, 203);
                                echo "</div>
                                          ";
                            }
                            // line 205
                            echo "                                        </div>
                                        <div class=\"product-price__main\">
                                          <span class=\"product-price__current price-new\">";
                            // line 207
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "special", [], "any", false, false, false, 207);
                            echo " за ";
                            echo ($context["text_mpn"] ?? null);
                            echo " ";
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "mpn", [], "any", false, false, false, 207);
                            echo "</span>
                                        </div>
                                        ";
                        }
                        // line 210
                        echo "                                        ";
                        if (twig_get_attribute($this->env, $this->source, $context["product"], "tax", [], "any", false, false, false, 210)) {
                            // line 211
                            echo "                                        <div class=\"product-price-tax\">";
                            echo ($context["text_tax"] ?? null);
                            echo " ";
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "tax", [], "any", false, false, false, 211);
                            echo "</div>
                                        ";
                        }
                        // line 213
                        echo "                                      </div>
                                      ";
                    }
                    // line 215
                    echo "                                      ";
                    if ((twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 215) == false)) {
                        // line 216
                        echo "                                      <div class=\"alert-price\">";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "attention", [], "any", false, false, false, 216);
                        echo "</div>
                                      ";
                    }
                    // line 218
                    echo "                                      ";
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 218)) {
                        // line 219
                        echo "                                      ";
                        if ((twig_get_attribute($this->env, $this->source, $context["product"], "quantity", [], "any", false, false, false, 219) <= 0)) {
                            // line 220
                            echo "                                      <div class=\"product-item__hidden\">
                                        <div class=\"product-item__quantity\">
                                          <i class=\"product-item__quantity-icon icon-danger\"></i>
                                          <span class=\"product-item__quantity-val\">";
                            // line 223
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "stock", [], "any", false, false, false, 223);
                            echo "</span>
                                        </div>
                                      </div>
                                      ";
                        } else {
                            // line 227
                            echo "                                      <div class=\"product-item__hidden\">
                                        <div class=\"product-item__quantity\">
                                          <i class=\"product-item__quantity-icon icon-success\"></i>
                                          <span class=\"product-item__quantity-val\">";
                            // line 230
                            echo ($context["text_instock"] ?? null);
                            echo "</span>
                                        </div>
                                      </div>
                                      ";
                        }
                        // line 234
                        echo "                                      ";
                        if (($context["quantity_btn"] ?? null)) {
                            // line 235
                            echo "                                      <!--<div class=\"product-item__amount\">
                                        <button type=\"button\" aria-label=\"Button minus\" class=\"minus product-item__amount-btn-minus\">-</button>
                                        <input type=\"text\" name=\"quantity\" class=\"product-item__amount-input\" size=\"2\" value=\"";
                            // line 237
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "minimum", [], "any", false, false, false, 237);
                            echo "\" data-maximum=\"";
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "quantity", [], "any", false, false, false, 237);
                            echo "\" />\t  
                                        <button type=\"button\" aria-label=\"Button plus\" class=\"plus product-item__amount-btn-plus\">+</button>
                                      </div>-->
                                      ";
                        }
                        // line 241
                        echo "                                      ";
                    }
                    // line 242
                    echo "                                    </div>
                                    <div class=\"product-button__container\">
                                    
                                    
                                      <button type=\"button\" class=\"btn btn-buy\" onclick=\"cart.add('";
                    // line 246
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "product_id", [], "any", false, false, false, 246);
                    echo "', \$(this).parent().parent().find('.product-item__amount-input').val());\">";
                    echo ($context["button_cart"] ?? null);
                    echo "</button>
                                    
                                    
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      
                      
                      
                      
                      
                    ";
                } elseif ((twig_get_attribute($this->env, $this->source,                 // line 263
$context["product"], "pmtemplate", [], "any", false, false, false, 263) == "productdver")) {
                    // line 264
                    echo "                      <div class=\"col-2 colx-xs-4 product-dver\">
                        <div class=\"product-item__container product-thumb\">
                          <div class=\"product-item\">
                          <!-- XD stickers start -->
\t\t\t\t\t";
                    // line 268
                    if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["product"], "product_xdstickers", [], "any", false, false, false, 268))) {
                        // line 269
                        echo "\t\t\t\t\t<div class=\"xdstickers_wrapper clearfix ";
                        echo ($context["xdstickers_position"] ?? null);
                        echo "\">
\t\t\t\t\t\t";
                        // line 270
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["product"], "product_xdstickers", [], "any", false, false, false, 270));
                        foreach ($context['_seq'] as $context["_key"] => $context["xdsticker"]) {
                            // line 271
                            echo "\t\t\t\t\t        ";
                            if ((twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 271) == "left")) {
                                // line 272
                                echo "\t\t\t\t\t\t\t<div class=\"xdstickers xdstickersdver ";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 272);
                                echo "\">
\t\t\t\t\t\t\t\t<div class=\"xdstickerbackground xdstickid";
                                // line 273
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 273);
                                echo "\" data-html=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 273);
                                echo "\" style=\"background-image: url('/";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "imagestick", [], "any", false, false, false, 273);
                                echo "');\" alt=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 273);
                                echo "\" datatyp=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "typet", [], "any", false, false, false, 273);
                                echo "\" datatwo=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 273);
                                echo "\"></div>
\t\t\t\t\t\t\t</div>
                              ";
                            }
                            // line 276
                            echo "                              
\t\t\t\t\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['xdsticker'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 278
                        echo "\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"xdstickers_wrapper clearfix xdright-two ";
                        // line 279
                        echo ($context["xdstickers_position"] ?? null);
                        echo "\">
\t\t\t\t\t\t";
                        // line 280
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["product"], "product_xdstickers", [], "any", false, false, false, 280));
                        foreach ($context['_seq'] as $context["_key"] => $context["xdsticker"]) {
                            // line 281
                            echo "\t\t\t\t\t        ";
                            if ((twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 281) == "right")) {
                                // line 282
                                echo "\t\t\t\t\t\t\t<div class=\"xdstickers xdstickersdver ";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 282);
                                echo "\">
\t\t\t\t\t\t\t\t<div class=\"xdstickerbackground xdstickid";
                                // line 283
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 283);
                                echo "\" data-html=\"true\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 283);
                                echo "\" style=\"background-image: url('/";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "imagestick", [], "any", false, false, false, 283);
                                echo "');\" alt=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "tooooltip", [], "any", false, false, false, 283);
                                echo "\" datatyp=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "typet", [], "any", false, false, false, 283);
                                echo "\" datatwo=\"";
                                echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "postiont", [], "any", false, false, false, 283);
                                echo "\"></div>
\t\t\t\t\t\t\t</div>
                              ";
                            }
                            // line 286
                            echo "                              
\t\t\t\t\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['xdsticker'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 288
                        echo "\t\t\t\t\t</div>
\t\t\t\t\t";
                    }
                    // line 290
                    echo "\t\t\t\t\t<!-- XD stickers end -->
                            <div class=\"product-item__image image\">
                                  <a href=\"";
                    // line 292
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "href", [], "any", false, false, false, 292);
                    echo "\" class=\"product-image\">
                                    <img src=\"";
                    // line 293
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "thumb", [], "any", false, false, false, 293);
                    echo "\" alt=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 293);
                    echo "\" title=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 293);
                    echo "\" class=\"img-responsive\" />\t\t
                                    ";
                    // line 294
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "percent", [], "any", false, false, false, 294)) {
                        // line 295
                        echo "                                    <div class=\"product-item-markers product-item-markers-icons\">
                                      <span class=\"product-item-marker-container product-item-marker-container-hidden\">
                                        <span class=\"product-item-marker product-item-marker-discount product-item-marker-14px\"><span>";
                        // line 297
                        echo (("-" . twig_get_attribute($this->env, $this->source, $context["product"], "percent", [], "any", false, false, false, 297)) . "%");
                        echo "</span></span>
                                      </span>
                                    </div>
                                    ";
                    }
                    // line 301
                    echo "                                  </a>
                                  <div class=\"product-item__icons\">
                                    <div class=\"product-item__delay\" data-toggle=\"tooltip\" title=\"";
                    // line 303
                    echo ($context["button_wishlist"] ?? null);
                    echo "\" onclick=\"wishlist.add('";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "product_id", [], "any", false, false, false, 303);
                    echo "');\">
                                      <i class=\"fi fi-rr-heart\"></i>
                                    </div>
                                  </div>
                                  ";
                    // line 307
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer_image", [], "any", false, false, false, 307)) {
                        // line 308
                        echo "                                  <div class=\"product-item__brand\">
                                    <img src=\"";
                        // line 309
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer_image", [], "any", false, false, false, 309);
                        echo "\" alt=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer", [], "any", false, false, false, 309);
                        echo "\" title=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer", [], "any", false, false, false, 309);
                        echo "\">
                                  </div>
                                  ";
                    }
                    // line 312
                    echo "                            </div>
                            <div class=\"product-item__basket caption\">
                              ";
                    // line 314
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "sku", [], "any", false, false, false, 314)) {
                        // line 315
                        echo "                              <div class=\"product-item__sku\">
                                <span class=\"product-item__text_sku\">";
                        // line 316
                        echo ($context["text_sku"] ?? null);
                        echo " ";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "sku", [], "any", false, false, false, 316);
                        echo "</span>
                              </div>
                              ";
                    }
                    // line 319
                    echo "                              <div class=\"product-item__title\">
                                <h3 class=\"product-item__heading\">
                                  <a href=\"";
                    // line 321
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "href", [], "any", false, false, false, 321);
                    echo "\"><span>";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 321);
                    echo "</span></a>
                                </h3>
                                ";
                    // line 323
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "hpm_block", [], "any", false, false, false, 323)) {
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "hpm_block", [], "any", false, false, false, 323);
                    }
                    // line 324
                    echo "                              </div>
                              <div class=\"product-item__info\">
                                <div class=\"product-item__caption-block\">
                                  <div class=\"product-item__caption\">
                                    <div class=\"product-item__blocks\">
                                      ";
                    // line 329
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 329)) {
                        // line 330
                        echo "                                      <div class=\"product-item__price\">
                                        ";
                        // line 331
                        if ( !twig_get_attribute($this->env, $this->source, $context["product"], "special", [], "any", false, false, false, 331)) {
                            // line 332
                            echo "                                        <div class=\"product-price__main\">
                                          <span class=\"product-price__current\">";
                            // line 333
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 333);
                            echo " за ";
                            echo ($context["text_mpn"] ?? null);
                            echo " ";
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "mpn", [], "any", false, false, false, 333);
                            echo "</span>
                                        </div>
                                        ";
                        } else {
                            // line 336
                            echo "                                        <div class=\"product-item-price-stock\">
                                          <div class=\"product-item-price-old\">";
                            // line 337
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 337);
                            echo "</div>
                                          ";
                            // line 338
                            if (twig_get_attribute($this->env, $this->source, $context["product"], "economy", [], "any", false, false, false, 338)) {
                                // line 339
                                echo "                                          <div class=\"product-item-price-economy\"> - ";
                                echo twig_get_attribute($this->env, $this->source, $context["product"], "economy", [], "any", false, false, false, 339);
                                echo "</div>
                                          ";
                            }
                            // line 341
                            echo "                                        </div>
                                        <div class=\"product-price__main\">
                                          <span class=\"product-price__current price-new\">";
                            // line 343
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "special", [], "any", false, false, false, 343);
                            echo " за ";
                            echo ($context["text_mpn"] ?? null);
                            echo " ";
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "mpn", [], "any", false, false, false, 343);
                            echo "</span>
                                        </div>
                                        ";
                        }
                        // line 346
                        echo "                                      </div>
                                      ";
                    }
                    // line 348
                    echo "                                      ";
                    if ((twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 348) == false)) {
                        // line 349
                        echo "                                      <div class=\"alert-price\">";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "attention", [], "any", false, false, false, 349);
                        echo "</div>
                                      ";
                    }
                    // line 351
                    echo "                                      ";
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 351)) {
                        // line 352
                        echo "                                      ";
                        if ((twig_get_attribute($this->env, $this->source, $context["product"], "quantity", [], "any", false, false, false, 352) <= 0)) {
                            // line 353
                            echo "                                      <div class=\"product-item__hidden\">
                                        <div class=\"product-item__quantity\">
                                          <i class=\"product-item__quantity-icon icon-danger\"></i>
                                          <span class=\"product-item__quantity-val\">";
                            // line 356
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "stock", [], "any", false, false, false, 356);
                            echo "</span>
                                        </div>
                                      </div>
                                      ";
                        } else {
                            // line 360
                            echo "                                      <div class=\"product-item__hidden\">
                                        <div class=\"product-item__quantity\">
                                          <i class=\"product-item__quantity-icon icon-success\"></i>
                                          <span class=\"product-item__quantity-val\">";
                            // line 363
                            echo ($context["text_instock"] ?? null);
                            echo "</span>
                                        </div>
                                      </div>
                                      ";
                        }
                        // line 367
                        echo "                                      ";
                    }
                    // line 368
                    echo "                                    </div>
                                    <div class=\"product-button__container\">
                                      <button type=\"button\" class=\"btn btn-buy\" onclick=\"cart.add('";
                    // line 370
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "product_id", [], "any", false, false, false, 370);
                    echo "', \$(this).parent().parent().find('.product-item__amount-input').val());\">";
                    echo ($context["button_cart"] ?? null);
                    echo "</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    ";
                } else {
                    // line 381
                    echo "                    
                    
                    
                      <div class=\"product-layout product-list col-12\">
                        <div class=\"product-item__container product-thumb\">
                          <div class=\"product-item\">
                          <!-- XD stickers start -->
\t\t\t\t\t";
                    // line 388
                    if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["product"], "product_xdstickers", [], "any", false, false, false, 388))) {
                        // line 389
                        echo "\t\t\t\t\t<div class=\"xdstickers_wrapper clearfix ";
                        echo ($context["xdstickers_position"] ?? null);
                        echo "\">
\t\t\t\t\t\t";
                        // line 390
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["product"], "product_xdstickers", [], "any", false, false, false, 390));
                        foreach ($context['_seq'] as $context["_key"] => $context["xdsticker"]) {
                            // line 391
                            echo "\t\t\t\t\t\t\t<div class=\"xdstickers ";
                            echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "id", [], "any", false, false, false, 391);
                            echo "\">
\t\t\t\t\t\t\t\t";
                            // line 392
                            echo twig_get_attribute($this->env, $this->source, $context["xdsticker"], "text", [], "any", false, false, false, 392);
                            echo "
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['xdsticker'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 395
                        echo "\t\t\t\t\t</div>
\t\t\t\t\t";
                    }
                    // line 397
                    echo "\t\t\t\t\t<!-- XD stickers end -->
                            <div class=\"product-item__image image\">
                                  <a href=\"";
                    // line 399
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "href", [], "any", false, false, false, 399);
                    echo "\" class=\"product-image\">
                                    <img src=\"";
                    // line 400
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "thumb", [], "any", false, false, false, 400);
                    echo "\" alt=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 400);
                    echo "\" title=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 400);
                    echo "\" class=\"img-responsive\" />\t\t
                                    ";
                    // line 401
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "percent", [], "any", false, false, false, 401)) {
                        // line 402
                        echo "                                    <div class=\"product-item-markers product-item-markers-icons\">
                                      <span class=\"product-item-marker-container product-item-marker-container-hidden\">
                                        <span class=\"product-item-marker product-item-marker-discount product-item-marker-14px\"><span>";
                        // line 404
                        echo (("-" . twig_get_attribute($this->env, $this->source, $context["product"], "percent", [], "any", false, false, false, 404)) . "%");
                        echo "</span></span>
                                      </span>
                                    </div>
                                    ";
                    }
                    // line 408
                    echo "                                  </a>
                                  <div class=\"product-item__icons\">
                                    <div class=\"product-item__delay\" data-toggle=\"tooltip\" title=\"";
                    // line 410
                    echo ($context["button_wishlist"] ?? null);
                    echo "\" onclick=\"wishlist.add('";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "product_id", [], "any", false, false, false, 410);
                    echo "');\">
                                      <i class=\"fi fi-rr-heart\"></i>
                                    </div>
                                  </div>
                                  ";
                    // line 414
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer_image", [], "any", false, false, false, 414)) {
                        // line 415
                        echo "                                  <div class=\"product-item__brand\">
                                    <img src=\"";
                        // line 416
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer_image", [], "any", false, false, false, 416);
                        echo "\" alt=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer", [], "any", false, false, false, 416);
                        echo "\" title=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer", [], "any", false, false, false, 416);
                        echo "\">
                                  </div>
                                  ";
                    }
                    // line 419
                    echo "                            </div>
                            <div class=\"product-item__basket caption caption\">
                              ";
                    // line 421
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "sku", [], "any", false, false, false, 421)) {
                        // line 422
                        echo "                              <div class=\"product-item__sku\">
                                <span class=\"product-item__text_sku\">";
                        // line 423
                        echo ($context["text_sku"] ?? null);
                        echo " ";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "sku", [], "any", false, false, false, 423);
                        echo "</span>
                              </div>
                              ";
                    }
                    // line 426
                    echo "                              <div class=\"product-item__title\">
                                <h3 class=\"product-item__heading\">
                                  <a href=\"";
                    // line 428
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "href", [], "any", false, false, false, 428);
                    echo "\"><span>";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 428);
                    echo "</span></a>
                                </h3>
                                ";
                    // line 430
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "hpm_block", [], "any", false, false, false, 430)) {
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "hpm_block", [], "any", false, false, false, 430);
                    }
                    // line 431
                    echo "                              </div>
                              <div class=\"product-item__info\">
                                <div class=\"product-item__caption-block\">
                                  <div class=\"product-item__caption\">
                                    <div class=\"product-item__blocks\">
                                      ";
                    // line 436
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 436)) {
                        // line 437
                        echo "                                      <div class=\"product-item__price\">
                                        ";
                        // line 438
                        if ( !twig_get_attribute($this->env, $this->source, $context["product"], "special", [], "any", false, false, false, 438)) {
                            // line 439
                            echo "                                        <div class=\"product-price__main\">
                                          <span class=\"product-price__current\">";
                            // line 440
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 440);
                            echo " за ";
                            echo ($context["text_mpn"] ?? null);
                            echo " ";
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "mpn", [], "any", false, false, false, 440);
                            echo "</span>
                                        </div>
                                        ";
                        } else {
                            // line 443
                            echo "                                        <div class=\"product-item-price-stock\">
                                          <div class=\"product-item-price-old\">";
                            // line 444
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 444);
                            echo "</div>
                                          ";
                            // line 445
                            if (twig_get_attribute($this->env, $this->source, $context["product"], "economy", [], "any", false, false, false, 445)) {
                                // line 446
                                echo "                                          <div class=\"product-item-price-economy\"> - ";
                                echo twig_get_attribute($this->env, $this->source, $context["product"], "economy", [], "any", false, false, false, 446);
                                echo "</div>
                                          ";
                            }
                            // line 448
                            echo "                                        </div>
                                        <div class=\"product-price__main\">
                                          <span class=\"product-price__current price-new\">";
                            // line 450
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "special", [], "any", false, false, false, 450);
                            echo " за ";
                            echo ($context["text_mpn"] ?? null);
                            echo " ";
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "mpn", [], "any", false, false, false, 450);
                            echo "</span>
                                        </div>
                                        ";
                        }
                        // line 453
                        echo "                                        ";
                        if (twig_get_attribute($this->env, $this->source, $context["product"], "tax", [], "any", false, false, false, 453)) {
                            // line 454
                            echo "                                        <div class=\"product-price-tax\">";
                            echo ($context["text_tax"] ?? null);
                            echo " ";
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "tax", [], "any", false, false, false, 454);
                            echo "</div>
                                        ";
                        }
                        // line 456
                        echo "                                      </div>
                                      ";
                    }
                    // line 458
                    echo "                                      ";
                    if ((twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 458) == false)) {
                        // line 459
                        echo "                                      <div class=\"alert-price\">";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "attention", [], "any", false, false, false, 459);
                        echo "</div>
                                      ";
                    }
                    // line 461
                    echo "                                      ";
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 461)) {
                        // line 462
                        echo "                                      ";
                        if ((twig_get_attribute($this->env, $this->source, $context["product"], "quantity", [], "any", false, false, false, 462) <= 0)) {
                            // line 463
                            echo "                                      <div class=\"product-item__hidden\">
                                        <div class=\"product-item__quantity\">
                                          <i class=\"product-item__quantity-icon icon-danger\"></i>
                                          <span class=\"product-item__quantity-val\">";
                            // line 466
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "stock", [], "any", false, false, false, 466);
                            echo "</span>
                                        </div>
                                      </div>
                                      ";
                        } else {
                            // line 470
                            echo "                                      <div class=\"product-item__hidden\">
                                        <div class=\"product-item__quantity\">
                                          <i class=\"product-item__quantity-icon icon-success\"></i>
                                          <span class=\"product-item__quantity-val\">";
                            // line 473
                            echo ($context["text_instock"] ?? null);
                            echo "</span>
                                        </div>
                                      </div>
                                      ";
                        }
                        // line 477
                        echo "                                      ";
                        if (($context["quantity_btn"] ?? null)) {
                            // line 478
                            echo "                                      <div class=\"product-item__amount\">
                                        <button type=\"button\" aria-label=\"Button minus\" class=\"minus product-item__amount-btn-minus\">-</button>
                                        <input type=\"text\" name=\"quantity\" class=\"product-item__amount-input\" size=\"2\" value=\"";
                            // line 480
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "minimum", [], "any", false, false, false, 480);
                            echo "\" data-maximum=\"";
                            echo twig_get_attribute($this->env, $this->source, $context["product"], "quantity", [], "any", false, false, false, 480);
                            echo "\" />\t  
                                        <button type=\"button\" aria-label=\"Button plus\" class=\"plus product-item__amount-btn-plus\">+</button>
                                      </div>
                                      ";
                        }
                        // line 484
                        echo "                                      ";
                    }
                    // line 485
                    echo "                                    </div>
                                    <div class=\"product-button__container\">
                                      <button type=\"button\" class=\"btn btn-buy\" onclick=\"cart.add('";
                    // line 487
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "product_id", [], "any", false, false, false, 487);
                    echo "', \$(this).parent().parent().find('.product-item__amount-input').val());\">";
                    echo ($context["button_cart"] ?? null);
                    echo "</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    
              ";
                    // line 497
                    echo ($context["content_bottom"] ?? null);
                    echo "
                    
                    
                    ";
                }
                // line 501
                echo "                      
                      
                      
                      
                      
                  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['product'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 507
            echo "                </div>
              </div>
              <div class=\"catalog-section-pagination\">
      <div class=\"row\">
        <div class=\"col-sm-6 text-left\">";
            // line 511
            echo ($context["pagination"] ?? null);
            echo "</div>
        <div class=\"col-sm-6 text-right\">";
            // line 512
            echo ($context["results"] ?? null);
            echo "</div>
      </div></div>
              ";
            // line 514
            if (($context["description"] ?? null)) {
                // line 515
                echo "              <div class=\"product-description\">
                <div class=\"form-group\">";
                // line 516
                echo ($context["description"] ?? null);
                echo "</div>
              </div>
              ";
            }
            // line 519
            echo "              ";
        }
        // line 520
        echo "              ";
        if (( !($context["categories"] ?? null) &&  !($context["products"] ?? null))) {
            // line 521
            echo "              <div class=\"text-empty\">
                <p>";
            // line 522
            echo ($context["text_empty"] ?? null);
            echo "</p>
                <div class=\"buttons clearfix\">
                  <div class=\"pull-right\"><a href=\"";
            // line 524
            echo ($context["continue"] ?? null);
            echo "\" class=\"btn btn-primary\">";
            echo ($context["button_continue"] ?? null);
            echo "</a></div>
                </div>
              </div>
              ";
        }
        // line 528
        echo "            </div>
          </div>
          ";
        // line 530
        echo ($context["column_right"] ?? null);
        echo "
        </div>
      </div>
    </div>
  </div>
</div>
";
        // line 536
        echo ($context["footer"] ?? null);
        echo "

<script type=\"text/javascript\">
  \$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
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
    \$(document).ready(function () {
  \$(\".thumbnails\").magnificPopup({
    type: \"image\",
    delegate: \"a\",
    gallery: {
      enabled: true
    }
  })
});
</script>";
    }

    public function getTemplateName()
    {
        return "stroimarket/template/product/category.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1382 => 536,  1373 => 530,  1369 => 528,  1360 => 524,  1355 => 522,  1352 => 521,  1349 => 520,  1346 => 519,  1340 => 516,  1337 => 515,  1335 => 514,  1330 => 512,  1326 => 511,  1320 => 507,  1309 => 501,  1302 => 497,  1287 => 487,  1283 => 485,  1280 => 484,  1271 => 480,  1267 => 478,  1264 => 477,  1257 => 473,  1252 => 470,  1245 => 466,  1240 => 463,  1237 => 462,  1234 => 461,  1228 => 459,  1225 => 458,  1221 => 456,  1213 => 454,  1210 => 453,  1200 => 450,  1196 => 448,  1190 => 446,  1188 => 445,  1184 => 444,  1181 => 443,  1171 => 440,  1168 => 439,  1166 => 438,  1163 => 437,  1161 => 436,  1154 => 431,  1150 => 430,  1143 => 428,  1139 => 426,  1131 => 423,  1128 => 422,  1126 => 421,  1122 => 419,  1112 => 416,  1109 => 415,  1107 => 414,  1098 => 410,  1094 => 408,  1087 => 404,  1083 => 402,  1081 => 401,  1073 => 400,  1069 => 399,  1065 => 397,  1061 => 395,  1052 => 392,  1047 => 391,  1043 => 390,  1038 => 389,  1036 => 388,  1027 => 381,  1011 => 370,  1007 => 368,  1004 => 367,  997 => 363,  992 => 360,  985 => 356,  980 => 353,  977 => 352,  974 => 351,  968 => 349,  965 => 348,  961 => 346,  951 => 343,  947 => 341,  941 => 339,  939 => 338,  935 => 337,  932 => 336,  922 => 333,  919 => 332,  917 => 331,  914 => 330,  912 => 329,  905 => 324,  901 => 323,  894 => 321,  890 => 319,  882 => 316,  879 => 315,  877 => 314,  873 => 312,  863 => 309,  860 => 308,  858 => 307,  849 => 303,  845 => 301,  838 => 297,  834 => 295,  832 => 294,  824 => 293,  820 => 292,  816 => 290,  812 => 288,  805 => 286,  789 => 283,  784 => 282,  781 => 281,  777 => 280,  773 => 279,  770 => 278,  763 => 276,  747 => 273,  742 => 272,  739 => 271,  735 => 270,  730 => 269,  728 => 268,  722 => 264,  720 => 263,  698 => 246,  692 => 242,  689 => 241,  680 => 237,  676 => 235,  673 => 234,  666 => 230,  661 => 227,  654 => 223,  649 => 220,  646 => 219,  643 => 218,  637 => 216,  634 => 215,  630 => 213,  622 => 211,  619 => 210,  609 => 207,  605 => 205,  599 => 203,  597 => 202,  593 => 201,  590 => 200,  580 => 197,  577 => 196,  575 => 195,  572 => 194,  570 => 193,  560 => 187,  554 => 186,  548 => 185,  542 => 183,  539 => 182,  534 => 181,  529 => 180,  527 => 179,  523 => 177,  519 => 176,  512 => 174,  508 => 172,  500 => 169,  497 => 168,  495 => 167,  491 => 165,  481 => 162,  478 => 161,  476 => 160,  467 => 156,  463 => 154,  456 => 150,  452 => 148,  450 => 147,  442 => 146,  438 => 145,  434 => 143,  430 => 141,  423 => 139,  407 => 136,  402 => 135,  399 => 134,  395 => 133,  391 => 132,  388 => 131,  381 => 129,  365 => 126,  360 => 125,  357 => 124,  353 => 123,  348 => 122,  346 => 121,  338 => 115,  336 => 114,  332 => 112,  328 => 111,  318 => 104,  314 => 103,  307 => 98,  301 => 97,  293 => 95,  285 => 93,  282 => 92,  278 => 91,  270 => 85,  264 => 84,  256 => 82,  248 => 80,  245 => 79,  241 => 78,  234 => 73,  231 => 72,  227 => 70,  222 => 67,  220 => 66,  216 => 64,  205 => 61,  195 => 58,  192 => 57,  189 => 56,  183 => 54,  181 => 53,  175 => 52,  165 => 51,  162 => 50,  158 => 49,  155 => 48,  153 => 47,  148 => 44,  146 => 43,  143 => 42,  132 => 39,  128 => 37,  126 => 36,  122 => 35,  116 => 33,  113 => 32,  110 => 31,  107 => 30,  104 => 29,  101 => 28,  98 => 27,  96 => 26,  92 => 25,  81 => 17,  75 => 13,  68 => 12,  62 => 11,  54 => 9,  52 => 8,  46 => 7,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "stroimarket/template/product/category.twig", "");
    }
}

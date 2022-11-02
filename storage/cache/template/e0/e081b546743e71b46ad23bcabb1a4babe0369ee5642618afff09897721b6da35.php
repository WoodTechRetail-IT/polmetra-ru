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

/* stroimarket/template/extension/module/special.twig */
class __TwigTemplate_56d6f5b0fb7c062c450f0633e47b12f2f2c6de42516f9ea935b8e0d97db85f8c extends \Twig\Template
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
        echo "<div class=\"container-push\">
  <div class=\"text-title\">
    ";
        // line 3
        if (($context["shadow_title"] ?? null)) {
            // line 4
            echo "    <div class=\"shadow-title\">";
            echo ($context["text_discount_goods"] ?? null);
            echo "</div>
    ";
        }
        // line 6
        echo "    <div class=\"content-title\">";
        echo ($context["heading_title"] ?? null);
        echo "</div>
  </div>
  <div class=\"row no-gutters\">
    ";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["products"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["product"]) {
            // line 10
            echo "    <div class=\"product-layout product-grid col-xxl-20 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6\">
      <div class=\"product-item__container\">
        <div class=\"product-item\">
          <div class=\"product-item__image\">
            <a href=\"";
            // line 14
            echo twig_get_attribute($this->env, $this->source, $context["product"], "href", [], "any", false, false, false, 14);
            echo "\" class=\"product-image\">
              <img src=\"";
            // line 15
            echo twig_get_attribute($this->env, $this->source, $context["product"], "thumb", [], "any", false, false, false, 15);
            echo "\" alt=\"";
            echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 15);
            echo "\" title=\"";
            echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 15);
            echo "\" class=\"img-responsive\" />\t\t
              ";
            // line 16
            if (twig_get_attribute($this->env, $this->source, $context["product"], "percent", [], "any", false, false, false, 16)) {
                // line 17
                echo "              <div class=\"product-item-markers product-item-markers-icons\">
                <span class=\"product-item-marker-container product-item-marker-container-hidden\">
                <span class=\"product-item-marker product-item-marker-discount product-item-marker-14px\"><span>";
                // line 19
                echo (("-" . twig_get_attribute($this->env, $this->source, $context["product"], "percent", [], "any", false, false, false, 19)) . "%");
                echo "</span></span>
                </span>
              </div>
              ";
            }
            // line 23
            echo "            </a>
            <div class=\"product-item__icons\">
              <div class=\"product-item__delay\" data-toggle=\"tooltip\" title=\"";
            // line 25
            echo ($context["button_wishlist"] ?? null);
            echo "\" onclick=\"wishlist.add('";
            echo twig_get_attribute($this->env, $this->source, $context["product"], "product_id", [], "any", false, false, false, 25);
            echo "');\">
                <i class=\"fi fi-rr-heart\"></i>
              </div>
            </div>
            ";
            // line 29
            if (twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer_image", [], "any", false, false, false, 29)) {
                // line 30
                echo "            <div class=\"product-item__brand\">
              <img src=\"";
                // line 31
                echo twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer_image", [], "any", false, false, false, 31);
                echo "\" alt=\"";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer", [], "any", false, false, false, 31);
                echo "\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "manufacturer", [], "any", false, false, false, 31);
                echo "\">
            </div>
            ";
            }
            // line 34
            echo "          </div>
          ";
            // line 35
            if (twig_get_attribute($this->env, $this->source, $context["product"], "sku", [], "any", false, false, false, 35)) {
                // line 36
                echo "          <div class=\"product-item__sku\">
            <span class=\"product-item__text_sku\">";
                // line 37
                echo ($context["text_sku"] ?? null);
                echo " ";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "sku", [], "any", false, false, false, 37);
                echo "</span>
          </div>
          ";
            }
            // line 40
            echo "          <div class=\"product-item__title\">
            <h3 class=\"product-item__heading\">
              <a href=\"";
            // line 42
            echo twig_get_attribute($this->env, $this->source, $context["product"], "href", [], "any", false, false, false, 42);
            echo "\"><span>";
            echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 42);
            echo "</span></a>
            </h3>
          </div>
          ";
            // line 45
            if (($context["review_status"] ?? null)) {
                // line 46
                echo "          <div class=\"rating product-item__rating\">\t\t    
            ";
                // line 47
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(range(1, 5));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 48
                    echo "            ";
                    if ((twig_get_attribute($this->env, $this->source, $context["product"], "rating", [], "any", false, false, false, 48) < $context["i"])) {
                        // line 49
                        echo "            <span class=\"star-empty\"><i class=\"fa fa-star\"></i></span>
            ";
                    } else {
                        // line 51
                        echo "            <span class=\"star\"><i class=\"fa fa-star\"></i></span>
            ";
                    }
                    // line 53
                    echo "            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 54
                echo "            <div class=\"reviews-count\">";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "reviews", [], "any", false, false, false, 54);
                echo "</div>
          </div>
          ";
            }
            // line 57
            echo "          <div class=\"product-item__info\">
            <div class=\"product-item__caption-block\">
              <div class=\"product-item__caption\">
                <div class=\"product-item__blocks\">
                  ";
            // line 61
            if (twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 61)) {
                // line 62
                echo "                  <div class=\"product-item__price\">
                    ";
                // line 63
                if ( !twig_get_attribute($this->env, $this->source, $context["product"], "special", [], "any", false, false, false, 63)) {
                    // line 64
                    echo "                    <div class=\"product-price__main\">
                      <span class=\"product-price__current\">";
                    // line 65
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 65);
                    echo "</span>
                    </div>
                    ";
                } else {
                    // line 68
                    echo "                    <div class=\"product-price__main\">
                      <span class=\"product-price__current price-new\">";
                    // line 69
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "special", [], "any", false, false, false, 69);
                    echo "</span>
                    </div>
                    <div class=\"product-item-price-stock\">
                      <div class=\"product-item-price-old\">";
                    // line 72
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 72);
                    echo "</div>
                      ";
                    // line 73
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "economy", [], "any", false, false, false, 73)) {
                        // line 74
                        echo "                      <div class=\"product-item-price-economy\"> - ";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "economy", [], "any", false, false, false, 74);
                        echo "</div>
                      ";
                    }
                    // line 76
                    echo "                    </div>
                    ";
                }
                // line 78
                echo "                    ";
                if (twig_get_attribute($this->env, $this->source, $context["product"], "tax", [], "any", false, false, false, 78)) {
                    // line 79
                    echo "                    <div class=\"product-price-tax\">";
                    echo ($context["text_tax"] ?? null);
                    echo " ";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "tax", [], "any", false, false, false, 79);
                    echo "</div>
                    ";
                }
                // line 81
                echo "                  </div>
                  ";
            }
            // line 83
            echo "                  ";
            if ((twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 83) == false)) {
                // line 84
                echo "                  <div class=\"alert-price\">";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "attention", [], "any", false, false, false, 84);
                echo "</div>
                  ";
            }
            // line 86
            echo "                  ";
            if (twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 86)) {
                // line 87
                echo "                  ";
                if ((twig_get_attribute($this->env, $this->source, $context["product"], "quantity", [], "any", false, false, false, 87) <= 0)) {
                    // line 88
                    echo "                  <div class=\"product-item__hidden\">
                    <div class=\"product-item__quantity\">
                      <i class=\"product-item__quantity-icon icon-danger\"></i>
                      <span class=\"product-item__quantity-val\">";
                    // line 91
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "stock", [], "any", false, false, false, 91);
                    echo "</span>
                    </div>
                  </div>
                  ";
                } else {
                    // line 95
                    echo "                  <div class=\"product-item__hidden\">
                    <div class=\"product-item__quantity\">
                      <i class=\"product-item__quantity-icon icon-success\"></i>
                      <span class=\"product-item__quantity-val\">";
                    // line 98
                    echo ($context["text_instock"] ?? null);
                    echo "</span>
                    </div>
                  </div>
                  ";
                }
                // line 102
                echo "                  ";
                if (($context["quantity_btn"] ?? null)) {
                    // line 103
                    echo "                  <div class=\"product-item__amount\">
                    <button type=\"button\" aria-label=\"Button minus\" class=\"minus product-item__amount-btn-minus\">-</button>
                    <input type=\"text\" name=\"quantity\" class=\"product-item__amount-input\" size=\"2\" value=\"";
                    // line 105
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "minimum", [], "any", false, false, false, 105);
                    echo "\" data-maximum=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "quantity", [], "any", false, false, false, 105);
                    echo "\" />\t  
                    <button type=\"button\" aria-label=\"Button plus\" class=\"plus product-item__amount-btn-plus\">+</button>
                  </div>
                  ";
                }
                // line 109
                echo "                  ";
            }
            // line 110
            echo "                </div>
                <div class=\"product-button__container\">
                  <button type=\"button\" class=\"btn btn-buy\" onclick=\"cart.add('";
            // line 112
            echo twig_get_attribute($this->env, $this->source, $context["product"], "product_id", [], "any", false, false, false, 112);
            echo "', \$(this).parent().parent().find('.product-item__amount-input').val());\"><span>";
            echo ($context["button_cart"] ?? null);
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
        // line 121
        echo "  </div>
</div>";
    }

    public function getTemplateName()
    {
        return "stroimarket/template/extension/module/special.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  321 => 121,  304 => 112,  300 => 110,  297 => 109,  288 => 105,  284 => 103,  281 => 102,  274 => 98,  269 => 95,  262 => 91,  257 => 88,  254 => 87,  251 => 86,  245 => 84,  242 => 83,  238 => 81,  230 => 79,  227 => 78,  223 => 76,  217 => 74,  215 => 73,  211 => 72,  205 => 69,  202 => 68,  196 => 65,  193 => 64,  191 => 63,  188 => 62,  186 => 61,  180 => 57,  173 => 54,  167 => 53,  163 => 51,  159 => 49,  156 => 48,  152 => 47,  149 => 46,  147 => 45,  139 => 42,  135 => 40,  127 => 37,  124 => 36,  122 => 35,  119 => 34,  109 => 31,  106 => 30,  104 => 29,  95 => 25,  91 => 23,  84 => 19,  80 => 17,  78 => 16,  70 => 15,  66 => 14,  60 => 10,  56 => 9,  49 => 6,  43 => 4,  41 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "stroimarket/template/extension/module/special.twig", "");
    }
}

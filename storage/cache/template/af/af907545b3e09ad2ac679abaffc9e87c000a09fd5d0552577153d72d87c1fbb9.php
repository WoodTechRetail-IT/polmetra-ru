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

/* stroimarket/template/extension/module/featured_product.twig */
class __TwigTemplate_7fdb7c35f821da27c665d28988a6e1cafc11fbd52c17c94983e38c98c013ad85 extends \Twig\Template
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
        if (($context["products"] ?? null)) {
            // line 2
            echo "<div class=\"text-title\">
  <div class=\"content-title\">";
            // line 3
            echo ($context["heading_title"] ?? null);
            echo "</div>
</div>
<div class=\"row no-gutters catalog-section__product\">
  ";
            // line 6
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["products"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["product"]) {
                // line 7
                echo "  <div class=\"product-layout col-xxl-20 col-lg-3 col-md-4 col-sm-6 col-12\">
    <div class=\"product-item__container\">
      <div class=\"product-item\">
        <div class=\"product-blog__image\">
          <a href=\"";
                // line 11
                echo twig_get_attribute($this->env, $this->source, $context["product"], "href", [], "any", false, false, false, 11);
                echo "\" class=\"product-image\"><img src=\"";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "thumb", [], "any", false, false, false, 11);
                echo "\" alt=\"";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 11);
                echo "\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 11);
                echo "\" class=\"img-responsive\" /></a>
        </div>
        <div class=\"caption blog-product__caption\">
          <div class=\"product-item__title blog-product__title\">
            <a href=\"";
                // line 15
                echo twig_get_attribute($this->env, $this->source, $context["product"], "href", [], "any", false, false, false, 15);
                echo "\"><strong>";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 15);
                echo "</strong></a>
          </div>
          <p>";
                // line 17
                echo twig_get_attribute($this->env, $this->source, $context["product"], "description", [], "any", false, false, false, 17);
                echo "</p>
          ";
                // line 18
                if (twig_get_attribute($this->env, $this->source, $context["product"], "rating", [], "any", false, false, false, 18)) {
                    // line 19
                    echo "          <div class=\"rating product-blog__rating\">
            ";
                    // line 20
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(range(1, 5));
                    foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                        // line 21
                        echo "            ";
                        if ((twig_get_attribute($this->env, $this->source, $context["product"], "rating", [], "any", false, false, false, 21) < $context["i"])) {
                            // line 22
                            echo "            <span class=\"star-empty\"><i class=\"fa fa-star\"></i></span>
            ";
                        } else {
                            // line 24
                            echo "            <span class=\"star\"><i class=\"fa fa-star\"></i></span>
            ";
                        }
                        // line 26
                        echo "            ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 27
                    echo "          </div>
          ";
                }
                // line 29
                echo "          ";
                if (twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 29)) {
                    // line 30
                    echo "          <p class=\"price\">
            ";
                    // line 31
                    if ( !twig_get_attribute($this->env, $this->source, $context["product"], "special", [], "any", false, false, false, 31)) {
                        // line 32
                        echo "            <span class=\"product-price__current\">";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 32);
                        echo "</span>
            ";
                    } else {
                        // line 34
                        echo "            <span class=\"price-new product-price__current\">";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "special", [], "any", false, false, false, 34);
                        echo "</span>
            <span class=\"price-old product-item-price-old\">";
                        // line 35
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "price", [], "any", false, false, false, 35);
                        echo "</span>
            ";
                    }
                    // line 37
                    echo "            ";
                    if (twig_get_attribute($this->env, $this->source, $context["product"], "tax", [], "any", false, false, false, 37)) {
                        echo " <span class=\"price-tax\">";
                        echo ($context["text_tax"] ?? null);
                        echo " ";
                        echo twig_get_attribute($this->env, $this->source, $context["product"], "tax", [], "any", false, false, false, 37);
                        echo "</span>
            ";
                    }
                    // line 38
                    echo " 
          </p>
          ";
                }
                // line 40
                echo " 
        </div>
        <div class=\"button-group button-blog__group\">
          <button type=\"button\" class=\"btn btn-primary btn-sm\" onclick=\"cart.add('";
                // line 43
                echo twig_get_attribute($this->env, $this->source, $context["product"], "product_id", [], "any", false, false, false, 43);
                echo "');\"><i class=\"fa fa-shopping-cart\"></i> <span class=\"hidden-xs hidden-sm hidden-md\">";
                echo ($context["button_cart"] ?? null);
                echo "</span></button>
          <button type=\"button\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" title=\"";
                // line 44
                echo ($context["button_wishlist"] ?? null);
                echo "\" onclick=\"wishlist.add('";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "product_id", [], "any", false, false, false, 44);
                echo "');\"><i class=\"fa fa-heart\"></i></button>
          <button type=\"button\" class=\"btn btn-default btn-sm\" data-toggle=\"tooltip\" title=\"";
                // line 45
                echo ($context["button_compare"] ?? null);
                echo "\" onclick=\"compare.add('";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "product_id", [], "any", false, false, false, 45);
                echo "');\"><i class=\"fa fa-exchange\"></i></button>
        </div>
      </div>
    </div>
  </div>
  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['product'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 50
            echo " 
</div>
";
        }
    }

    public function getTemplateName()
    {
        return "stroimarket/template/extension/module/featured_product.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  182 => 50,  168 => 45,  162 => 44,  156 => 43,  151 => 40,  146 => 38,  136 => 37,  131 => 35,  126 => 34,  120 => 32,  118 => 31,  115 => 30,  112 => 29,  108 => 27,  102 => 26,  98 => 24,  94 => 22,  91 => 21,  87 => 20,  84 => 19,  82 => 18,  78 => 17,  71 => 15,  58 => 11,  52 => 7,  48 => 6,  42 => 3,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "stroimarket/template/extension/module/featured_product.twig", "");
    }
}

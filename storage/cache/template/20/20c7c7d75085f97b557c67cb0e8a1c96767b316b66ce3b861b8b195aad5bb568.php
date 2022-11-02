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

/* default/template/extension/module/wallbrand.twig */
class __TwigTemplate_9c79360df2638aeff72633badcbe6c8b8a2faef690388bc2016132c987b2bc47 extends \Twig\Template
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
        echo "<div class=\"wrapper-brands__new\">
  <div class=\"wrapper-brands__container\">
    <div class=\"wrapper-brands__header\">
      <div class=\"row\">
        <div class=\"col-lg-6 col-md-6 col-sm-6 wrapper-brands__link\">
          <div class=\"content-title\">
            <i class=\"ion-ios-star\"></i> ";
        // line 7
        echo ($context["heading_title"] ?? null);
        echo "
          </div>
        </div>
        <div class=\"col-lg-6 col-md-6 col-sm-6 text-right\">
          <div class=\"brands-new__show__all text-right\">
            <a href=\"";
        // line 12
        echo ($context["brands"] ?? null);
        echo "\">
              <p>";
        // line 13
        echo ($context["all_brands"] ?? null);
        echo " <i class=\"ion-ios-arrow-thin-right\"></i></p>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class=\"brands-new\">
      <div class=\"row\">
        ";
        // line 21
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["manufacturers"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["manufacturer"]) {
            // line 22
            echo "        <div class=\"col-lg-2 col-md-4 col-sm-6 col-xs-6 brands-new__item\">
          <a href=\"";
            // line 23
            echo twig_get_attribute($this->env, $this->source, $context["manufacturer"], "href", [], "any", false, false, false, 23);
            echo "\" class=\"brand-link\"><img src=\"";
            echo twig_get_attribute($this->env, $this->source, $context["manufacturer"], "thumb", [], "any", false, false, false, 23);
            echo "\" alt=\"";
            echo twig_get_attribute($this->env, $this->source, $context["manufacturer"], "name", [], "any", false, false, false, 23);
            echo "\" title=\"";
            echo twig_get_attribute($this->env, $this->source, $context["manufacturer"], "name", [], "any", false, false, false, 23);
            echo "\" class=\"img-responsive\" /></a>     
        </div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['manufacturer'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo "      </div>
    </div>
  </div>
</div>";
    }

    public function getTemplateName()
    {
        return "default/template/extension/module/wallbrand.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  90 => 26,  75 => 23,  72 => 22,  68 => 21,  57 => 13,  53 => 12,  45 => 7,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "default/template/extension/module/wallbrand.twig", "");
    }
}

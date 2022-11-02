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

/* default/template/extension/module/ldev_question/ldev_question.twig */
class __TwigTemplate_3158e3074e94c9cac4b2446564bf7b0f458ab17f582483257625ba20c9e83b56 extends \Twig\Template
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
        echo "
";
        // line 2
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["results"] ?? null));
        foreach ($context['_seq'] as $context["k"] => $context["result"]) {
            // line 3
            echo "
        <div id=\"ldev-question-block-id-";
            // line 4
            echo twig_get_attribute($this->env, $this->source, $context["result"], "item_id", [], "any", false, false, false, 4);
            echo "\" class=\"ldev-question ";
            echo twig_get_attribute($this->env, $this->source, $context["result"], "display", [], "any", false, false, false, 4);
            echo " ";
            if (($context["include_css_js"] ?? null)) {
                echo " ldev-question-local ";
            }
            echo " ";
            if (twig_get_attribute($this->env, $this->source, $context["result"], "container", [], "any", false, false, false, 4)) {
                echo " container ";
            }
            echo "\">
            ";
            // line 5
            echo twig_get_attribute($this->env, $this->source, $context["result"], "view", [], "any", false, false, false, 5);
            echo "
        </div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['k'], $context['result'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 8
        echo "
";
        // line 9
        if (($context["exist_selectors"] ?? null)) {
            // line 10
            echo "<script>
\$(function(){
        ";
            // line 12
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["results"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["result"]) {
                // line 13
                echo "        ";
                if (twig_get_attribute($this->env, $this->source, $context["result"], "selector", [], "any", false, false, false, 13)) {
                    // line 14
                    echo "    ";
                    echo twig_replace_filter(twig_get_attribute($this->env, $this->source, $context["result"], "selector", [], "any", false, false, false, 14), ["[module]" => (("\"#ldev-question-block-id-" . twig_get_attribute($this->env, $this->source, $context["result"], "item_id", [], "any", false, false, false, 14)) . "\"")]);
                    echo "
       ";
                }
                // line 16
                echo "    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['result'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 17
            echo "});
</script>
";
        }
        // line 20
        echo "

";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["results"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["result"]) {
            // line 23
            echo "    ";
            echo twig_get_attribute($this->env, $this->source, $context["result"], "microdata_view", [], "any", false, false, false, 23);
            echo "
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['result'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "default/template/extension/module/ldev_question/ldev_question.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  111 => 23,  107 => 22,  103 => 20,  98 => 17,  92 => 16,  86 => 14,  83 => 13,  79 => 12,  75 => 10,  73 => 9,  70 => 8,  61 => 5,  47 => 4,  44 => 3,  40 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "default/template/extension/module/ldev_question/ldev_question.twig", "");
    }
}

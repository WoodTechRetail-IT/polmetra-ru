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

/* stroimarket/template/common/column_left.twig */
class __TwigTemplate_85cf3815a53ad52f7be7478215f8ba37d932899d9db72c031afe4ea8b392b2c5 extends \Twig\Template
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
        if (($context["modules"] ?? null)) {
            // line 2
            echo "<aside id=\"column-left\" class=\"col-sm-3 hidden-xs\">
  ";
            // line 3
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["modules"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["module"]) {
                // line 4
                echo "  ";
                echo $context["module"];
                echo "
  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['module'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 6
            echo "  <div class=\"right-form\">
        <div class=\"div-quest\">Остались вопросы?</div><div class=\"text-form-qw\">Свяжитесь с нами и мы ответим на них.</div><div class=\"phone-form-qw\">+7 (499) 348-11-16</div>
        
       
            \t<form id=\"forma-quest\" class=\"forma-quest\">

                <!-- Hidden Required Fields -->
                <input type=\"hidden\" name=\"form_subject\" value=\"Форма - Заказ звонка (Polmetra.ru)\">
                <input type=\"hidden\" name=\"aurl\" value=\"";
            // line 14
            echo ($context["aurl"] ?? null);
            echo "\">
                <input type=\"hidden\" name=\"project_name\" value=\"Polmetra.ru\">
                <input type=\"hidden\" name=\"form_subject\" value=\"Заказ звонка (Polmetra.ru)\">
                <!-- END Hidden Required Fields -->
                <div class=\"forms-inputheadcall\">
                    <input type=\"text\" name=\"name\" class=\"chcksp\" placeholder=\"Ваше имя...\" maxlength=\"25\">
                    <input type=\"text\" name=\"text\" class=\"chcksp\" placeholder=\"Ваше имя...\" maxlength=\"25\">
                    <input type=\"text\" name=\"tname\" placeholder=\"Ваше имя...\" maxlength=\"25\">
                </div>
            \t\t<!-- END Hidden Required Fields -->
            \t\t<div class=\"inputs-forma\">
            \t\t<input class=\"phone_masckcom\" type=\"text\" name=\"Phone\" placeholder=\"Ваш телефон...\" required><br>
            \t\t</div>
            \t\t<button class=\"style-form-button\">Отправить</button>
            
            \t</form>
            \t<script>
                    \$(document).ready(function() {
                    \t\$(\"#forma-quest\").submit(function() {
                    \t\tvar th = \$(this);
                    \t\t\$.ajax({
                    \t\t\ttype: \"POST\",
                    \t\t\turl: \"mail.php\",
                    \t\t\tdata: th.serialize()
                    \t\t}).done(function() {
                    \t\t\talert(\"Благодарим за заявку!\");
                    \t\t\tsetTimeout(function() {
                    \t\t\t\t// Done Functions
                    \t\t\t\tth.trigger(\"reset\");
                    \t\t\t}, 1000);
                    \t\t});
                    \t\treturn false;
                    \t});
                    });
                    </script>
    </div>
</aside>
";
        }
    }

    public function getTemplateName()
    {
        return "stroimarket/template/common/column_left.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 14,  55 => 6,  46 => 4,  42 => 3,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "stroimarket/template/common/column_left.twig", "");
    }
}

<?php

/* hello-world.html */
class __TwigTemplate_c171798ca733b44bd71b185d2dbd8a5e7e43e96c19c745c907174b25b741a1d3 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html>
<head>
</head>
<body>
";
        // line 5
        echo twig_escape_filter($this->env, ($context["hello"] ?? null), "html", null, true);
        echo "
";
        // line 6
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('session')->getCallable(), array("usuario")), "html", null, true);
        echo "
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "hello-world.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  33 => 6,  29 => 5,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<html>
<head>
</head>
<body>
[[hello]]
[[ session('usuario') ]]
</body>
</html>", "hello-world.html", "C:\\wamp\\www\\pulque-lite\\ui\\modules\\hello\\hello-world.html");
    }
}

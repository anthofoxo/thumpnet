<?php session_start();?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <?php include "metadata.html";?>
        <title>ThumpNet</title>
        <link rel="preload" href="/images/default_thumb.jpg" as="image"/>
        <link rel="stylesheet" href="layout.css"/>
        <link rel="stylesheet" href="landing.css"/>

        <script src="/htmx.min.js"></script>
        <script src="/mustache.js"></script>
        <script src="/thumpnet-client-side-templates.js"></script>

        <template id="level-cards">
            <?php include "card-template.mustache";?>
        </template>
    </head>
    <body>
        <?php include "header.php";?>
        <div hx-ext="thumpnet-client-side-templates">
            <div style="margin-bottom:8px;">
                ThumpNet is a custom level host for <a href="https://thumpergame.com/">Thumper</a>.
                This is a succesor and more permanent solution to the efforts by Bigphish.
                I'm <a href="discord://-/users/218415631479996417">@anthofoxo</a>, lead dev of the website and api.
                Join the <a href="https://discord.gg/FU2X9z4ttJ">thumper discord</a>.

                <a href="https://github.com/CocoaMix86/Thumper-Custom-Level-Editor/releases/tag/2.0">Thumper custom level editor 2.0</a>
                <a href="https://docs.google.com/document/d/1zwrpMhfugF7f_sxgpWUM9_cnOXtubOyFIqd7TCRryxM">Thumper manual 2.0</a>
            </div>

            <div id="levels" hx-get="/api/?resolve=user" hx-trigger="load" thumpnet-template="level-cards"></div>
        </div>
    </body>
</html>
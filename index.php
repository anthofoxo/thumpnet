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

        <script defer src="/marked.min.js"></script>
        <script defer src="/prism.min.js"></script>
        <script type="module" src="/zero-md.min.js"></script>

        <template id="level-cards"></template>
        <script src="/include.js" data-fetch="/card-template.mustache" data-target="level-cards"></script>
    </head>
    <body>
        <?php include "header.php";?>
        <div>
            <zero-md src="/about.md">
                <template>
                    <link rel="stylesheet" href="/global.css"/>
                </template>
            </zero-md>
            
            <div id="levels" hx-ext="thumpnet-client-side-templates" hx-get="/api/?resolve=user" hx-trigger="load" thumpnet-template="level-cards"></div>
        </div>
    </body>
</html>
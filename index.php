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
        <div>
            <div hx-get="/detail/title.html" hx-trigger="load"></div>
            <div id="header" hx-get="/detail/subtitle.php" hx-trigger="load"></div>
        </div>
        <div id="content" hx-get="landing.html" hx-trigger="load"></div>
    </body>
</html>
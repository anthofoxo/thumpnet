// Modified version of the `client-side-templates` extension
htmx.defineExtension('thumpnet-client-side-templates', {
    transformResponse : function(text, xhr, elt) {

        var mustacheTemplate = htmx.closest(elt, '[thumpnet-template]');
        if (mustacheTemplate) {
            var data = JSON.parse(text);

            // Transform response json first
            for(level of data.levels)
            {
                level.uploader = data.resolve.user[level.uploader];
                level.authors = level.authors.flatMap((author_id) => (data.resolve.user[author_id]));
            }

            var templateId = mustacheTemplate.getAttribute('thumpnet-template');
            var template = htmx.find("#" + templateId);
            if (template) {
                return Mustache.render(template.innerHTML, data);
            } else {
                throw "Unknown mustache template: " + templateId;
            }
        }    
    }
});
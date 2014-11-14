    function getSlug(Text)
    {
        return Text
                .toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '')
                ;
    }

    function updateValue() {
        var title = document.getElementById("title").value;
        document.getElementById("slug").value = getSlug(title);
    }
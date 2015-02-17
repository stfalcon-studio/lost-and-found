var $collectionHolder;

// setup an "add a tag" link
var $addPhotoLink = $('<a href="#" class="add_photo_link">Add a photo</a>');
var $newLinkLi = $('<p></p>').append($addPhotoLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    var type = $('.type').data().type;
    if (type == 'lost')
        $collectionHolder = $('#lost_item_photos');
    else
        $collectionHolder = $('#found_item_photos');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addPhotoLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addPhotoForm($collectionHolder, $newLinkLi);
    });
});

function addPhotoForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');
    if (index == 0)
        index = 1;
    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__label__/g, '<i>'+index + ' photo</i>');
    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li style="list-style-type: none;"></li>').append(newForm);
    $newFormLi.append('<a href="#" class="remove-photo">Delete a photo</a>');
    $newLinkLi.before($newFormLi);

    $('.remove-photo').click(function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });
}

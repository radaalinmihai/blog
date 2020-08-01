window.onload = function() {
    let posts = document.getElementsByClassName('card-text');
    Array.from(posts).forEach(function(post) {
        post.innerHTML = marked(post.innerHTML);
    });
}
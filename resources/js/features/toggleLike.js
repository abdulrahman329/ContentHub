export async function toggleLike(type, id, btn) {

    const token = document.querySelector(
        'meta[name="csrf-token"]'
    ).content;

    const response = await fetch('/likes/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ type, id })
    });

    if (!response.ok) return;

    const data = await response.json();

    // styel for likes
    btn.innerText = data.liked ? '❤️' : '🤍';

    // count of likes
    const counter = document.getElementById(`like-count-${type}-${id}`);
    if (counter) {
        counter.innerText = data.likes_count;
    }

    // badge of author
    const badge = document.getElementById(`author-badge-${type}-${id}`);
    if (badge) {
        badge.classList.toggle('hidden', !data.author_liked);
    }
}
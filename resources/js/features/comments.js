export function toggleEdit(id) {

    const view = document.getElementById(`view-${id}`);
    const edit = document.getElementById(`edit-${id}`);

    view.classList.toggle('hidden');
    edit.classList.toggle('hidden');
}

export function toggleReply(id) {
    const form = document.getElementById(`reply-form-${id}`);
    if (!form) return;

    form.classList.toggle('hidden');
}
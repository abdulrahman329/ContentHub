export function toggleEdit(id) {

    const view = document.getElementById(`view-${id}`);
    const edit = document.getElementById(`edit-${id}`);

    view.classList.toggle('hidden');
    edit.classList.toggle('hidden');
}
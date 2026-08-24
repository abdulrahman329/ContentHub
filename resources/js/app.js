import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { toggleLike } from './features/toggleLike';
import { toggleEdit } from './features/comments';
import { toggleReply } from './features/comments';


window.toggleReply = toggleReply;
window.toggleLike = toggleLike;
window.toggleEdit = toggleEdit;

import './features/theme';

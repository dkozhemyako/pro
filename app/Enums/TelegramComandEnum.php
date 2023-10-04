<?php

namespace App\Enums;

enum TelegramComandEnum: string
{
    case INFO = '/info';
    case CREATE_BOOK = '/createBook';
    case UPDATE_BOOK = '/updateBook';
    case DELETE_BOOK = '/deleteBook';
    case SHOW_BOOK = '/showBook';
    case LOAD_BOOK = '/loadBook';

}

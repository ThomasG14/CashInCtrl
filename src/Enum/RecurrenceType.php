<?php

namespace App\Enum;

enum RecurrenceType: string
{
    case WEEKLY = 'weekly'; //date = 1 to 7
    case MONTHLY = 'monthly'; //date = 1 to 31
    case ENDMONTHLY = 'endmonthly';// denier du mois
    case LASTDAYOFWORK = 'lastdayofwork'; // dernier jour ouvrable de travail (or weekend)
}

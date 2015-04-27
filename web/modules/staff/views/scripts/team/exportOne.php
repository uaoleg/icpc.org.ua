<html><head><meta content="text/html; charset=UTF-8" http-equiv="Content-Type">

    <meta charset="UTF-8">

    <title>CodePen - A4 CSS page template</title>

    <style>
        page[size="A4"] {
            background: white;
            width: 21cm;
            height: 29.7cm;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
        }

        page[size="A4"] #header td{
            text-align: center;
        }

        table
        {
            font-size: 14px;;
            width:100%;
        }


        #sign {
            width: 21cm;
            margin-top: 30px;
        }

        td.substring
        {
            font-size: 10px;
            text-align: center;
        }

        table.header
        {
            margin-top: 5px;
        }

        th{
            text-align: left;
            background: #c0c0c0;
        }

        td.space {
            border-bottom: solid 1px;
        }

        @media print {
            body, page[size="A4"] {
                margin: 0;
                box-shadow: 0;
            }

            #sign {
                position: absolute;
                bottom: 0cm;
            }
        }

    </style>
</head>

<body>

<page size="A4">
    <table width="100%" id="header">
        <tr>
            <td>РЕЄСТРАЦІЙНА ФОРМА КОМАНДИ</td>
        </tr>
        <tr>
            <td>першого етапу Всеукраїнської студентської олімпіади з програмування <?= $team->year ?> року</td>
        </tr>
    </table>

    <table width="100%" class="header">
        <tr>
            <th colspan="4">Назва ВНЗ</th>
        </tr>
        <tr>
            <td width="1px">
                Повна(укр):
            </td>
            <td class="space">
                <?= $team->school->fullNameUk ?>
            </td>
            <td width="1px">
                Скорочена
            </td>
            <td class="space" width="150px">
                <?= $team->school->shortNameUk ?>
            </td>
        </tr>
        <tr>
            <td width="1px">
                Повна(англ):
            </td>
            <td class="space" colspan="3">
                <?= $team->school->fullNameEn ?>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td width="350px">
                Офіційна повна поштова (з індексом) і електронна адреси
            </td>
            <td class="space">
            </td>
        </tr>
        <tr>
            <td class="space" colspan="2"> &nbsp;
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td width="490px">
                Група ВНЗ (класичні, технічні, педагогічні, економічні, природничі, гуманітарні)
            </td>
            <td class="space"
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td width="100px">
                Назва команди
            </td>
            <td class="space">
                <?= $team->name ?>
            </td>
        </tr>
    </table>

    <!----- Тренер --->
    <table class="header">
        <tr>
            <th>Тренер</th>
        </tr>
    </table>

    <table>
        <tr>
            <td width="175px">
                Прізвище, ім'я, по-батькові
            </td>
            <td class="space" colspan="3">
                <?= $team->coachNameUk ?>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td width="135px">
                Ім'я, прізвище (англ):
            </td>
            <td class="space">
                <?= $team->coachNameEn ?>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td width="50px">
                Посада:
            </td>
            <td class="space">
                <?= $team->coach->info->position ?>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td width="90px">
                Робоча адреса:
            </td>
            <td class="space">
                <?= $team->coach->info->officeAddress ?>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td width="170px">
                Електронна адреса (e-mail):
            </td>
            <td class="space">
                <?= $team->coach->email ?>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td width="120px">
                Телефони робочий:
            </td>
            <td class="space">
                <?= $team->coach->info->phoneWork ?>
            </td>
            <td width="50px">
                домашній:
            </td>
            <td class="space">
                <?= $team->coach->info->phoneHome ?>
            </td>
            <td width="50px">
                мобільний:
            </td>
            <td class="space">
                <?= $team->coach->info->phoneMobile ?>
            </td>
        </tr>
    </table>

    <!--- Участники --->

    <?php
        $index = 1;
        foreach ($team->members as $member)
        {
    ?>

            <table class="header">
                <tr>
                    <th><?= (($index < 4) ? "Учасник {$index}" : "Запасний учасник") ?></th>
                </tr>
            </table>

            <table>
                <tr>
                    <td width="170px">
                        Прізвище, ім'я, по-батькові
                    </td>
                    <td class="space" colspan="3">
                        <?= $member->lastNameUk ?> <?= $member->firstNameUk ?> <?= $member->middleNameUk ?>
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td width="135px">
                        Ім'я, прізвище (англ):
                    </td>
                    <td class="space">
                        <?= $member->lastNameEn ?> <?= $member->firstNameEn ?> <?= $member->middleNameEn ?>
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td width="110px">
                        Напрям навчання
                    </td>
                    <td class="space">
                        <?= $member->info->studyField ?>
                    </td>

                    <td width="90px">
                        Спеціальність
                    </td>
                    <td class="space">
                        <?= $member->info->speciality ?>
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td width="120px">
                        Рік вступу до ВНЗ
                    </td>
                    <td class="space">
                        <?= $member->info->schoolAdmissionYear ?>
                    </td>
                    <td width="30px">
                        Курс
                    </td>
                    <td class="space">
                        <?= $member->info->course ?>
                    </td>
                    <td width="130px">
                        Студентський квиток
                    </td>
                    <td class="space">
                        <?= $member->info->document ?>
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td width="110px">
                        Дата народження
                    </td>
                    <td class="space">
                        <?= date("d.m.Y",$member->info->dateOfBirth) ?>
                    </td>

                    <td width="50px">
                        E-mail
                    </td>
                    <td class="space">
                        <?= $member->email ?>
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td width="125px">
                        Телефон домашній:
                    </td>
                    <td class="space">
                        <?= $member->info->phoneHome ?>
                    </td>
                    <td width="50px">
                        мобільний:
                    </td>
                    <td class="space">
                        <?= $member->info->phoneMobile ?>
                    </td>
                </tr>
            </table>
            <?php
            $index++;
        }
    ?>


    <div id="sign">
        <table class="header">
            <tr>
                <td width="250px">
                    Проректор з наукової роботи:
                </td>
                <td class="space">

                </td>
                <td width="50px">

                </td>
                <td class="space">
                </td>
            </tr>
            <tr>
                <td width="250px">
                </td>
                <td class="substring">
                    (Підпис)
                </td>
                <td width="50px">

                </td>
                <td class="substring">
                    (Прізвище, ініціали)
                </td>
            </tr>
        </table>

        <table class="header">

        </table>

        <table class="header">
            <tr>
                <td>
                    Місце печатки
                </td>
                <td>

                </td>
                <td width="120px">
                    Дата заповнення
                </td>
                <td class="space" width="100px">
                </td>
                <td width="75px">
                    <?= date('Y') ?> року
                </td>
            </tr>
        </table>
    </div>


</page>

</body></html>
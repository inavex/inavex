<?php
/**
 * Template Name: Страница - Калькулятор износа по Положению ЦБ РФ №432-П
 */

get_header();

// Get parent page ID
$parent_id = get_the_ID(); ?>

    <div id="main-wrap" class="wrap">

        <?php
        // Action hook to add content before main
        do_action( 'frameshift_main_before' );

        // Open layout wrap
        frameshift_layout_wrap( 'main-middle-wrap' );
        ?>

        <div id="main-middle" class="row">

            <?php
            // Set class of #content div depending on active sidebars
            $content_class = ( is_active_sidebar( 'sidebar-page' ) || is_active_sidebar( 'sidebar' ) ) ? frameshift_get_span( 'big' ) : frameshift_get_span( 'full' );

            // Set class depending on individual page layout
            if( get_post_meta( $parent_id, '_layout', true ) == 'full-width' )
                $content_class = frameshift_get_span( 'full' );
            ?>

            <div id="content" class="<?php echo $content_class; ?>">

            <div <?php post_class( 'clearfix' ); ?>>

                <?php
                // Action hook before post title
                do_action( 'frameshift_post_title_before' );
                ?>

                <?php
                // Action hook after post title
                do_action( 'frameshift_post_title_after' );

                // Action hook before post content
                do_action( 'frameshift_post_content_before' );
                ?>

                <div class="post-teaser clearfix">
                    <?php the_content(); ?>
                </div>

                <?php
                // Action hook after post content
                do_action( 'frameshift_post_content_after' );
                ?>

            </div><!-- .post-<?php the_ID(); ?> -->

            <form action="/wp-content/themes/inavex/calculator/getCalcDoc/getCalcDocx3.php" method="POST" id="calcForm">
                    <h2>Выберите тип транспортного средства<span class="required">*</span></h2>
                    <div style="margin-bottom: 20px;">
                        <select name="deltaId" id="" class="span8-1" style="display: inline-block">
                            <option value="0">Легковые автомобили, производства Российской Федерации</option>
                            <option value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ВАЗ</option>
                            <option value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ГАЗ</option>
                            <option value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ЗАЗ</option>
                            <option value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ТагАЗ</option>
                            <option value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;УАЗ</option>
                            <option value="0">Легковые автомобили, производства стран Азии (кроме Японии и Кореи)</option>
                            <option value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Brilliance</option>
                            <option value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BYD</option>
                            <option value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DerwaysChery</option>
                            <option value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FAW</option>
                            <option value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Geely</option>
                            <option value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Great</option>
                            <option value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Wall</option>
                            <option value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hafei</option>
                            <option value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Haima</option>
                            <option value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lifan</option>
                            <option value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Luxgen</option>
                            <option value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Xin Kai</option>
                            <option value="0">Легковые автомобили, производства стран Европы, включая Турцию </option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aston Martin</option>, , , , , , , , , , , , , , , , , , , , ,
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bentley</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bugatti</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ferrari</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jaguar</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Maserati</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Porsche Audi</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BMW</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mercedes-Benz</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mini</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rover Alfa Romeo</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Citroen</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fiat</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ford</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opel</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Peugeot</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Renault</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saab</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SEAT</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Skoda</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Volkswagen</option>
                            <option value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Volvo</option>
                            <option value="0">Легковые автомобили, производства стран Северной и Южной Америк</option>
                            <option value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Acura</option>
                            <option value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Buick</option>
                            <option value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cadillac</option>
                            <option value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chevrolet</option>
                            <option value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chrysler</option>
                            <option value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dodge</option>
                            <option value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hummer</option>
                            <option value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Infiniti</option>
                            <option value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jeep</option>
                            <option value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lexus</option>
                            <option value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lincoln</option>
                            <option value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mercury</option>
                            <option value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pontiac</option>
                            <option value="0">Легковые автомобили, производства Кореи</option>
                            <option value="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hyundai</option>
                            <option value="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kia</option>
                            <option value="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ssang Yong</option>
                            <option value="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Daewoo</option>
                            <option value="0">Легковые автомобили, производства Японии</option>
                            <option value="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Daihatsu</option>
                            <option value="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Honda</option>
                            <option value="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Isuzu</option>
                            <option value="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mazda</option>
                            <option value="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mitsubishi</option>
                            <option value="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nissan</option>
                            <option value="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Subaru</option>
                            <option value="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Suzuki</option>
                            <option value="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Toyota</option>
                            <option value="7">Грузовые, грузовые бортовые автомобили, грузовые фургоны,  автомобили самосвалы и тягачи, независимо от марки</option>
                            <option value="8">Автобусы независимо от марки</option>
                            <option value="9">Троллейбусы и вагоны трамваев независимо от марки</option>
                            <option value="10">Прицепы и полуприцепы для грузовых автомобилей независимо от марки</option>
                            <option value="11">Прицепы для легковых автомобилей и жилых автомобилей (типа автомобиль-дача) независимо от марки</option>
                            <option value="12">Мотоциклы независимо от марки</option>
                            <option value="13">Скутеры, мопеды, мотороллеры независимо от марки</option>
                            <option value="14">Сельскохозяйственные тракторы, самоходная, пожарная, коммунальная, погрузочная, строительная, дорожная, землеройная, иная техника на базе автомобилей и иных самоходных баз</option>
                            <option value="15">Велосипеды независимо от марки</option>
                        </select>
                        <div style="display: inline-block;width: 50px; margin-left: 10px; margin-right: 5px; text-align: center;">
                            <label for="">∆T</label>
                            <input type="text" disabled id="delta1" class="span1" style="width: 50px;"/>
                        </div>
                        <div style="display: inline-block;width: 50px; margin-left: 5px; margin-right: 10px; text-align: center;">
                            <label for="">∆L</label>
                            <input type="text" disabled id="delta2" class="span1" style="width: 50px;"/>
                        </div>
                    </div>

                    <div style="float: left; width: 560px;">
                        <h2>Укажите данные для расчета износа комплектующих изделий (деталей, узлов и агрегатов) транспортного средства</h2>

                        <table class="b-table-calc">
                            <tr>
                                <td>
                                        <label for="date-now">Текущая дата</label>
                                        <div class="">
                                            <input name="date-now" id="date-now" type="text" value="" class="medium span2-2 datepicker" tabindex="1">
                                        </div>
                                </td>
                                <td>
                                        <label for="date-ts">Дата начала эксплуатации ТС<span class="required">*</span></label>
                                        <div class="">
                                            <input name="date-ts" id="date-ts" type="text" value="" class="medium span2-2 datepicker" tabindex="1">
                                        </div>
                                </td>
                                <td>
                                        <label for="date-dtp">Дата дтп<span class="required">*</span></label>
                                        <div class="">
                                            <input name="date-dtp" id="date-dtp" type="text" value="" class="medium span2-2 datepicker" tabindex="1">
                                        </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <label for="probeg-ts">Пробег ТС<span class="required">*</span></label>
                                        <div class="">
                                            <input name="probeg-ts" id="probeg-ts" type="text" value="" class="medium span2-2" tabindex="1">
                                        </div>
                                </td>
                                <td><!--
                                        <label for="gsk">Гарантия от сквозной <br>коррозии (лет)<span class="required">*</span></label>
                                        <div class="">
                                            <input name="gsk" id="gsk" type="text" value="" class="medium span2-2" tabindex="1">
                                        </div> -->
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"><!--
                                    <label for="vozrast-ts">Возраст ТС по комментариям к ПП №361 (в полных годах, лет)</label>
                                    <div class="">
                                        <input name="vozrast-ts" id="vozrast-ts" type="text" value="" class="medium span3" disabled  tabindex="1">
                                        <input type="radio" name="type-vozrast" value="1" class="vozrast-radio" checked>
                                    </div>-->
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <label for="vozrast-ts2">Срок эксплуатации комплектующего изделия (детали, узла, агрегата), (лет)</label>
                                    <div class="">
                                        <input name="vozrast-ts2" id="vozrast-ts2" type="text" value="" class="medium span3" disabled  tabindex="1">
                                        <!--<input type="radio" name="type-vozrast" value="2" class="vozrast-radio">-->
                                    </div>
                                </td>
                            </tr>


                        </table>
                    </div>

                    <div style="float: right; width: 220px;">
                        <!--<h2>Укажите данные для расчета износа аккумуляторной батареи</h2>

                        <table class="b-table-calc">
                            <tr>
                                <td style="padding-right: 0">
                                    <div>
                                        <label for="fact-acum">Фактическая дата аккумулятора</label>
                                        <div class="">
                                            <input name="fact-acum" id="fact-acum" type="text" value="" style="width: 200px" class="medium span2 datepicker" tabindex="1">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>-->
                    </div>

                    <div class="cl" style="clear: both"></div>

                    <h2>Укажите данные для расчета износа шин</h2>

                    <table class="b-table-calc">
                        <tr>
                            <td>
                                <div>
                                    <label for="fact-hp">Фактическая высота рисунка протектора</label>
                                    <div class="">
                                        <input name="fact-hp" id="fact-hp" type="text" value="" class="medium span2" tabindex="1">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <label for="fact-shina-date">Фактическая дата выпуска шины</label>
                                    <div class="">
                                        <input name="fact-shina-date" id="fact-shina-date" type="text" value=""  class="medium span2 datepicker" tabindex="1">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <label for="new-height-shina">Высота рисунка протектора новой шины (мм)</label>
                                    <div class="">
                                        <input name="new-height-shina" id="new-height-shina" type="text" value="" style="width: 160px" class="medium span2" tabindex="1">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <label for="fact-shina">Минимальная допустимая высота протектора</label>
                                    <div class="">
                                        <select name="minHeight" id="" class="span4">
                                            <option value="1.6">Легковые автомобили - 1.6мм</option>
                                            <option value="1">Грузовые автомобили - 1.0мм</option>
                                            <option value="2">Автобусы автомобили - 2.0мм</option>
                                            <option value="0.8">Мотоциклы и мопеды - 0.8мм</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <p style="margin: 1em 0 2em;"><a href="#" class="btn btn-large" id="submitCalc" style="line-height: 1.15em;" />Раcсчитать</a> <input type="submit" value="Скачать в формате Word" class="btn btn-large disabled"/> <a href="http://inavex.ru/nomenklatura/" class="btn btn-large" id="" style="line-height: 1.15em;" />Номенклатура комплектующих изделий, с нулевым значение износа.</a></p>
                </form>


                <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/jquery-ui-1.10.3.custom.min.css"/>
                <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.maskedinput.min.js"></script>
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {

                        //$(".datepicker").datepicker();

                        //$('.datepicker').formance('format_dd_mm_yyyy');

                        $(".datepicker").mask("99.99.9999");

                        var url = "/wp-content/themes/inavex/calculator/calculator4.php";

                        $('select[name="deltaId"]').on("change", function(){
                            $.ajax({
                                type: "POST",
                                url: url,
                                dataType: 'json',
                                data: $("#calcForm").serialize(), // serializes the form's elements.
                                success: function(data) {
                                    $('#delta1').val(data.delta[0]);
                                    $('#delta2').val(data.delta[1]);
                                }
                            });
                        });

                        $("#submitCalc").click(function() {

                            // Проверка самых главных полей
                            if ($("#calcForm select[name='deltaId']").val() == 0) {

                                $('.b-calc-result').hide();
                                $('.b-calc-result__title').fadeIn(200);
                                $('.b-calc-result__error').fadeIn(200);
                                $('.b-calc-result__error-description').text('Выберите тип транспортного средства!');

                            } else if (!$("#calcForm input[name='date-ts']").val()) {

                                $('.b-calc-result').hide();
                                $('.b-calc-result__title').fadeIn(200);
                                $('.b-calc-result__error').fadeIn(200);
                                $('.b-calc-result__error-description').text('Вы не указали дату выпуска ТС!');

                            } else if (!$("#calcForm input[name='date-dtp']").val()) {

                                $('.b-calc-result').hide();
                                $('.b-calc-result__title').fadeIn(200);
                                $('.b-calc-result__error').fadeIn(200);
                                $('.b-calc-result__error-description').text('Вы не указали дату ДТП!');

                            } else if (!$("#calcForm input[name='probeg-ts']").val()) {

                                $('.b-calc-result').hide();
                                $('.b-calc-result__title').fadeIn(200);
                                $('.b-calc-result__error').fadeIn(200);
                                $('.b-calc-result__error-description').text('Вы не указали пробег ТС!');

                            }
                            //else if (!$("#calcForm input[name='gsk']").val()) {
                            //
                            //    $('.b-calc-result').hide();
                            //    $('.b-calc-result__title').fadeIn(200);
                            //    $('.b-calc-result__error').fadeIn(200);
                            //    $('.b-calc-result__error-description').text('Вы не указали гарантию от сквозной коррозии!');
                            //
                            //}

                            // проверка шин
                            else if (($("#calcForm input[name='fact-hp']").val() || $("#calcForm input[name='fact-shina-date']").val() || $("#calcForm input[name='new-height-shina']").val()) && (!$("#calcForm input[name='fact-hp']").val() || !$("#calcForm input[name='fact-shina-date']").val() || !$("#calcForm input[name='new-height-shina']").val())) {

                                $('.b-calc-result').hide();
                                $('.b-calc-result__title').fadeIn(200);
                                $('.b-calc-result__error').fadeIn(200);
                                $('.b-calc-result__error-description').text('Для рассчета износа шины транспортного средства, заполните фактическую высоту и дату, а также высоту рисунка новой шины!');

                            } else {

                            var url = "/wp-content/themes/inavex/calculator/calculator4.php";

                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    dataType: 'json',
                                    data: $("#calcForm").serialize(), // serializes the form's elements.
                                    success: function(data) {

                                        console.log(data);

                                        if (!data.errors) {

                                            $('#vozrast-ts').val(data.ageOfVehicle);
                                            $('#vozrast-ts2').val(data.yearsByMR);
                                            $('#depreciationBody .value').text(data.depreciationBody+'%');
                                            $('#depreciationPlastic .value').text(data.depreciationPlastic+'%');
                                            $('#depreciationOfOtherParts .value').text(data.depreciationOfOtherParts+'%');
                                            $('#depreciationTires .value').text(data.depreciationTires+'%');

                                            if (data.depreciationTires == 'noDataForTires') {
                                                $('#depreciationTires').hide();
                                            } else {
                                                $('#depreciationTires').show();
                                                $('#depreciationTires .value').text(data.depreciationTires+'%');
                                            }

                                            if (data.depreciationBattery == 'noDataForBattery') {
                                                $('#depreciationBattery').hide();
                                            } else {
                                                $('#depreciationBattery').show();
                                                $('#depreciationBattery .value').text(data.depreciationBattery+'%');
                                            }


                                            $('.b-calc-result__error').hide();
                                            $('.b-calc-result__title').fadeIn(200);
                                            $('.b-calc-result').fadeIn(200);

                                        } else {

                                            if (data.errors == 'notValidSymbols') {
                                                $('.b-calc-result').hide();
                                                $('.b-calc-result__title').fadeIn(200);
                                                $('.b-calc-result__error').fadeIn(200);
                                                $('.b-calc-result__error-description').text('Используйте только цифры и точки для указания данных!');
                                            } else if (data.errors == 'noData') {
                                                $('.b-calc-result').hide();
                                                $('.b-calc-result__title').fadeIn(200);
                                                $('.b-calc-result__error').fadeIn(200);
                                                $('.b-calc-result__error-description').text('Вы не указали никаких данных!');
                                            }

                                        }

                                    }
                                });

                                }

                            return false;
                        });

                        $("#calcForm input[type='text'], #calcForm select").change(function(){
                            if ($("#calcForm select[name='deltaId']").val() && $("#calcForm input[name='date-ts']").val() && $("#calcForm input[name='date-dtp']").val() /*&& $("#calcForm input[name='gsk']").val()*/ ) {
                                $("#calcForm input[type='submit']").removeClass('disabled');
                            } else {
                                $("#calcForm input[type='submit']").addClass('disabled');
                            }
                        });

                        $("#calcForm input[type='submit']").click(function(){
                            if($(this).hasClass('disabled')) {
                                $('.b-calc-result').hide();
                                $('.b-calc-result__title').fadeIn(200);
                                $('.b-calc-result__error').fadeIn(200);
                                $('.b-calc-result__error-description').text('Для вывода результатов в формате Word заполните обязательные поля!');
                                return false;
                            }
                        });


                    });
                </script>

                <h2 class="b-calc-result__title" style="display: none">Результат:</h2>

                <div class="b-calc-result__error" style="display: none;">
                    <b>Невозможно рассчитать результат:</b> <span class="b-calc-result__error-description"></span>
                </div>

                <table class="b-calc-result" style="display: none">
                    <!--<tr id="depreciationBody">
                        <td>Износ несъемных элементов кузова транспортного средства принимается равным</td>
                        <td class="value"></td>
                    </tr>
                    <tr id="depreciationPlastic">
                        <td>Износ пластиковых элементов транспортного средства принимается равным</td>
                        <td class="value"></td>
                    </tr>  -->
                    <tr id="depreciationOfOtherParts">
                        <td>Износ комплектующих изделий (деталей, узлов и агрегатов) транспортного средства</td>
                        <td class="value"></td>
                    </tr>
                    <tr id="depreciationTires" style="display: none";>
                        <td>Износ шины транспортного средства принимается равным </td>
                        <td class="value"></td>
                    </tr>
                    <tr id="depreciationBattery" style="display: none">
                        <td>Износ аккумуляторной батареи транспортного средства принимается равным</td>
                        <td class="value"></td>
                    </tr>
                </table>

                <style type="text/css">

                    #calcForm h2 {
                        line-height: 1.5em;
                        margin-bottom: .8em;
                    }

                    .b-calc-result {
                        margin-bottom: 2em;
                    }

                    .b-calc-result td {
                        padding: .6em 1em;
                        font-weight: bold;
                    }

                    .b-calc-result td:first-child {
                        font-weight: normal;
                    }


                    .b-table-calc {
                        margin: 0 -1.4em 1.6em;
                        width: auto;
                        background: #FDFDFD;
                        padding: 1em 1.5em;
                        border-radius: .2em;
                        border-collapse: separate;
                    }

                    .b-table-calc label {}

                    .b-table-calc .span3 {
                        width: 240px;
                    }

                    .b-table-calc td {
                        border: none;
                        padding: .6em 2em .6em 0;
                        vertical-align: bottom;
                    }

                    .b-calc-result__error {
                        padding: 2em;
                        border: 1px dotted red;
                        background: rgb(252, 240, 240);
                        margin-bottom: 2em;
                    }

                    .required {
                        margin-left: 4px;
                        color: red;
                    }

                    .span2-2 {
                        width: 148px;
                    }

                    .vozrast-radio {
                        margin: 0 1em !important;
                        position: relative;
                        top: -.4em;
                    }

                </style>



            <div style="margin-top: 10px; margin-bottom: 40px;">
                <?php
                $homePost = get_post('2313');
                echo apply_filters( 'the_content', $homePost->post_content );
                ?>
            </div>


            </div><!-- #content -->

            <?php get_sidebar(); ?>

        </div><!-- #main-middle -->

        <?php
        // Close layout wrap
        frameshift_layout_wrap( 'main-middle-wrap', 'close' );

        // Action hook to add content after main
        do_action( 'frameshift_main_after' );
        ?>

    </div><!-- #main-wrap -->

<?php get_footer(); ?>
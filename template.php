<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if ($arResult["isFormNote"] == "Y"):?>
    <!-- успешная отправка формы -->
    <div class="custom-form-success">
        <?=$arResult["FORM_NOTE"]?>
    </div>
<?else:?>

    <?if ($arResult["isFormErrors"] == "Y"):?>
        <!-- ошибки валидации формы -->
        <div class="custom-form-errors">
            <?=$arResult["FORM_ERRORS_TEXT"];?>
        </div>
    <?endif;?>

    <div class="contact-form">

        <div class="contact-form__head">
        <?if ($arResult["isFormTitle"]):?>
            <div class="contact-form__head-title">
                <?=$arResult["FORM_TITLE"];?>
            </div>
        <?endif;?>

        <?if ($arResult["isFormDescription"]):?>
            <div class="contact-form__head-text">
                <?=$arResult["FORM_DESCRIPTION"];?>
            </div>
        <?endif;?>
        </div>

    <div class="contact-form__form">
        
        <?=$arResult["FORM_HEADER"]?>

        <div class="contact-form__form-inputs">

            <?foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion):
                // определение структуры формы (вопросы) для кастомизации инпутов
                $arAnswer = current($arQuestion["STRUCTURE"]);
                $fieldName = "form_" . $arAnswer["FIELD_TYPE"] . "_" . $arAnswer["ID"];
                $value = isset($_REQUEST[$fieldName]) ? htmlspecialcharsbx($_REQUEST[$fieldName]) : "";
                ?>

                <?if ($arAnswer["FIELD_TYPE"] == 'text'):?>
                    <label class="input__label" for="field_<?=$arAnswer["ID"]?>">
                        <div class="input__label-text">
                            <?=$arQuestion["CAPTION"]?>
                            <?if ($arQuestion["REQUIRED"] == "Y"):?>
                                    <span class="required-star">*</span>
                            <?endif;?>
                        </div>
  
                        <div class="input contact-form__input">
                            <input 
                                type="text" 
                                id="field_<?=$arAnswer["ID"]?>"
                                name="<?=$fieldName?>" 
                                value="<?=$value?>"
                                class="input__input"
                                <?=($arQuestion["REQUIRED"] == "Y") ? "required" : ""?>
                            />
                        </div>
                    </label>
                <?endif;?>

                <?if ($arAnswer["FIELD_TYPE"] == 'textarea'):?>
                    <!--закрываем <div class="contact-form__form-inputs"> -->
                    </div>
                    <div class="contact-form__form-message">
                        <label class="input__label-textarea" for="field_<?=$arAnswer["ID"]?>">
                            <div class="input__label-text">
                                    <?=$arQuestion["CAPTION"]?>
                                    <?if ($arQuestion["REQUIRED"] == "Y"):?>
                                            <span class="required-star">*</span>
                                    <?endif;?>
                            </div>
                                                    
                            <textarea 
                                id="field_<?=$arAnswer["ID"]?>"
                                name="<?=$fieldName?>" 
                                
                                <?=($arQuestion["REQUIRED"] == "Y") ? "required" : ""?>
                            >		<?=$value?>
                            </textarea>
                                            
                       </label>
                    </div>
				<?endif;?>
            
            <?endforeach;?>
        
            <!-- Капча (если включена) -->
            <?if($arResult["isUseCaptcha"] == "Y"):?>
                <div class="custom-form-captcha">
                    <input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" />
                    <div class="captcha-image">
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" alt="CAPTCHA" />
                    </div>
                    <div class="captcha-input">
                        <input type="text" name="captcha_word" size="30" maxlength="50" class="custom-input-text" required placeholder="Введите символы с картинки" />
                    </div>
                </div>
            <?endif;?>

            <!-- Кнопка отправки формы-->
    <div class="contact-form__bottom">
        <div class="contact-form__bottom-policy">Нажимая &laquo;Оставить заявку&raquo;, Вы&nbsp;подтверждаете, что
            ознакомлены, полностью согласны и&nbsp;принимаете условия &laquo;Согласия на&nbsp;обработку персональных
            данных&raquo;.
        </div>
			<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type = "submit" name="web_form_submit" 
					class="form-button contact-form__bottom-button form-button__title" value = "Оставить заявку">
    </div>

    <?=$arResult["FORM_FOOTER"]?>
    </div>
</div>
<?endif;?>

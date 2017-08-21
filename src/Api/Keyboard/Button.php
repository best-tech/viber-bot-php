<?php

namespace Viber\Api\Keyboard;

use Viber\Api\Entity;

/**
 * Keyboard button.
 *
 * Pressing a keyboard button would trigger a different reply depending on the
 * buttons “ActionType” value.
 *
 * @see https://developers.viber.com/tools/keyboards/index.html
 * @see https://developers.viber.com/img/keyboard_guidelines.png
 *
 * @author Novikov Bogdan <hcbogdan@gmail.com>
 */
class Button extends Entity
{
    /**
     * Button width in columns (1-6)
     *
     * @var integer
     */
    protected $Columns = 6;

    /**
     * Button height in rows (1-2)
     *
     * @var integer
     */
    protected $Rows = 1;

    /**
     * Background color of button
     *
     * @var string
     */
    protected $BgColor;

    /**
     * Type of the background media ("picture" or "gif")
     * For picture - JPEG and PNG files are supported.
     * Max size: 500 kb
     *
     * @var string
     */
    protected $BgMediaType;

    /**
     * URL for background media content.
     * Will be placed with aspect to fill logic.
     *
     * @var string
     */
    protected $BgMedia;

    /**
     * When true - animated background media (gif) will loop continuously.
     * When false - animated background media will play once and stop.
     *
     * @var boolean
     */
    protected $BgLoop;

    /**
     * Type of action pressing the button will perform.
     * "reply" - will send a reply to the PA.
     * "open-url" - will open the specified URL and send the URL as reply to the PA.
     *
     * @see https://developers.viber.com/tools/keyboards/index.html#replyLogic
     *
     * @var string
     */
    protected $ActionType;

    /**
     * Text for reply ActionType OR URL for "open-url".
     * For ActionType reply - text
     * For ActionType open-url - Valid URL.
     * Max length: Android - 250 characters; iOS - 100 characters
     *
     * @var string
     */
    protected $ActionBody;

    /**
     * URL of image to place on top of background (if any). Can be a partially
     * transparent image that will allow showing some of the background.
     * Will be placed with aspect to fill logic.
     *
     * Valid URL. JPEG and PNG files are supported. Max size: 500 kb
     *
     * @var string
     */
    protected $Image;

    /**
     * Text to be displayed on the button. Can contain some HTML tags.
     *
     * Free text. Valid and allowed HTML tags Max 250 characters. If the text
     * is too long to display on the button it will be cropped and ended
     * with "..."
     *
     * @var string
     */
    protected $Text;

    /**
     * Vertical alignment of the text
     *
     * Avail: top, middle, bottom
     *
     * @var string
     */
    protected $TextVAlign;

    /**
     * Horizontal align of the text
     *
     * Avail: left, center, right
     *
     * @var string
     */
    protected $TextHAlign;

    /**
     * Text opacity. Range: 0-100
     *
     * @var integer
     */
    protected $TextOpacity;

    /**
     * Text size out of 3 available options: small, regular, large
     *
     * @var string
     */
    protected $TextSize;

    protected $OpenURLType;
    protected $OpenURLMediaType;

    public function __construct($buttonKeyVal = false, $flowCurrent = false)
    {
        if (!$buttonKeyVal || !$flowCurrent) {
            return;
        }
        
        foreach ($buttonKeyVal as $key => $buttonName) {
            $arrayButton = $flowCurrent->buttons[$buttonName] ?? false;
            if (!$arrayButton) {
                return;
            }
            $this->setActionType($arrayButton['ТипДействия'] ?? null);
            $this->setActionBody($arrayButton['Действие'] ?? "*");
            $this->setColumns($arrayButton['Колонок'] ?? null);
            $this->setRows($arrayBubbon['Строк'] ?? null);
            $this->setBgColor($arrayBubbon['ЦветФона'] ?? null);
            $this->setBgMediaType($arrayButton['ТипКартинки'] ?? null);
            if (isset($arrayButton['Фон']) && $arrayButton['Фон']) {
                $this->setBgMedia($flowCurrent->images[$arrayButton['Фон']]['Данные'] ?? null);
            }
            if (isset($arrayButton['Картинка']) && $arrayButton['Картинка']) {
                $this->setImage( $flowCurrent->images[$arrayButton['Картинка']]['Данные'] ?? null);
            }
        
            $this->setText($arrayButton['Наименование'] ?? null);
            $this->setTextOpacity($arrayButton['ПрозрачностьТекста'] ?? null);
            $this->setTextHAlign($arrayButton['ГоризонтальноеВыравнивание'] ?? null);
            $this->setTextVAlign($arrayButton['ВертикальноеВыравнивание'] ?? null);
            $this->setTextSize($arrayButton['РазмерТекста'] ?? null);
            $this->setOpenURLType($arrayButton['КакОтркытьСсылку'] ?? null);
            $this->setOpenURLMediaType($arrayButton['КакОткрытьМедиа'] ?? null);
        }
    }
        
    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return [
        'Columns' => $this->getColumns(),
        'Rows' => $this->getRows(),
        'BgColor' => $this->getBgColor(),
        'BgMediaType' => $this->getBgMediaType(),
        'BgMedia' => $this->getBgMedia(),
        'BgLoop' => $this->getBgLoop(),
        'ActionType' => $this->getActionType(),
        'ActionBody' => $this->getActionBody(),
        'Image' => $this->getImage(),
        'Text' => $this->getText(),
        'TextVAlign' => $this->getTextVAlign(),
        'TextHAlign' => $this->getTextHAlign(),
        'TextOpacity' => $this->getTextOpacity(),
        'TextSize' => $this->getTextSize(),
        'OpenURLType' => $this->getOpenURLType(),
        'OpenURLMediaType' => $this->getOpenURLMediaType()
        ];
    }

    public function getOpenURLType()
    {
        return $this->OpenURLType;
    }

    public function getOpenURLMediaType()
    {
        return $this->OpenURLMediaType;
    }

    public function setOpenURLType($OpenURLType)
    {
        if (!$OpenURLType || $OpenURLType!=="internal" || $OpenURLType!=="external") {
            return $this;
        }
        $this->OpenURLType = $OpenURLType;

        return $this;
    }

    public function setOpenURLMediaType($OpenURLMediaType)
    {
        if (!$OpenURLMediaType || $OpenURLMediaType!=="not-media" || $OpenURLMediaType!=="picture" || $OpenURLMediaType!=="video" || $OpenURLMediaType!=="gif") {
            return $this;
        }
        $this->OpenURLMediaType = $OpenURLMediaType;

        return $this;
    }

    /**
     * Get the value of Button width in columns (1-6)
     *
     * @return integer
     */
    public function getColumns()
    {
        return $this->Columns;
    }

    /**
     * Set the value of Button width in columns (1-6)
     *
     * @param integer Columns
     *
     * @return self
     */
    public function setColumns($Columns)
    {
        if (!$Columns) {
            return;
        }
        $Columns = (int) $Columns;
        if ($this->Columns===6 && $Columns ===6) {
            return;
        }

        if ($Columns>6) {
            return;
        }
        if ($Columns<1) {
            return;
        }
        
        $this->Columns = $Columns;

        return $this;
    }

    /**
     * Get the value of Button height in rows (1-2)
     *
     * @return integer
     */
    public function getRows()
    {
        return $this->Rows;
    }

    /**
     * Set the value of Button height in rows (1-2)
     *
     * @param integer Rows
     *
     * @return self
     */
    public function setRows($Rows)
    {
        
        if (!$Rows) {
            return;
        }
        $Rows = (int) $Rows;
        if ($Rows<1) {
            return;
        }
        if ($Rows>7) {
            return;
        }

        $this->Rows = $Rows;

        return $this;
    }

    /**
     * Get the value of Background color of button
     *
     * @return string
     */
    public function getBgColor()
    {
        return $this->BgColor;
    }

    /**
     * Set the value of Background color of button
     *
     * @param string BgColor
     *
     * @return self
     */
    public function setBgColor($BgColor)
    {
        $pregma = '/\#([a-fA-F]|[0-9]){3, 6}/';
        if (!preg_match($pregma, $BgColor)) {
            return $this;
        }
        $this->BgColor = $BgColor;

        return $this;
    }

    /**
     * Get the value of Type of the background media ("picture" or "gif")
     *
     * @return string
     */
    public function getBgMediaType()
    {
        return $this->BgMediaType;
    }

    /**
     * Set the value of Type of the background media ("picture" or "gif")
     *
     * @param string BgMediaType
     *
     * @return self
     */
    public function setBgMediaType($BgMediaType)
    {
        if (!$BgMediaType) {
            return;
        }
        if ($BgMediaType==='picture' && $BgMediaType==='gif') {
            $this->BgMediaType = $BgMediaType;
        }

        return $this;
    }

    /**
     * Get the value of URL for background media content.
     *
     * @return string
     */
    public function getBgMedia()
    {
        return $this->BgMedia;
    }

    /**
     * Set the value of URL for background media content.
     *
     * @param string BgMedia
     *
     * @return self
     */
    public function setBgMedia($BgMedia)
    {
        $this->BgMedia = $BgMedia;

        return $this;
    }

    /**
     * Get the value of When true - animated background media (gif) will loop continuously.
     *
     * @return boolean
     */
    public function getBgLoop()
    {
        return $this->BgLoop;
    }

    /**
     * Set the value of When true - animated background media (gif) will loop continuously.
     *
     * @param boolean BgLoop
     *
     * @return self
     */
    public function setBgLoop($BgLoop)
    {
        $this->BgLoop = $BgLoop;

        return $this;
    }

    /**
     * Get the value of Type of action pressing the button will perform.
     *
     * @return string
     */
    public function getActionType()
    {
        return $this->ActionType;
    }

    /**
     * Set the value of Type of action pressing the button will perform.
     *
     * @param string ActionType
     *
     * @return self
     */
    public function setActionType($ActionType)
    {
        if (!$ActionType || $ActionType==='reply' || $ActionType==="ОтправитьДанные") {
            // $this->ActionType = "reply";
            return $this;
        }
        if ($ActionType==="ОткрытьСсылку" || $ActionType==="open-url") {
            $this->ActionType = "open-url";
            return $this;
        }
        if ($ActionType==="НичегоНеДелать" || $ActionType==="none") {
            $this->ActionType = "none";
            return $this;
        }
        
        // $this->ActionType = $ActionType;

        return $this;
    }

    /**
     * Get the value of Text for reply ActionType OR URL for "open-url".
     *
     * @return string
     */
    public function getActionBody()
    {
        return $this->ActionBody;
    }

    /**
     * Set the value of Text for reply ActionType OR URL for "open-url".
     *
     * @param string ActionBody
     *
     * @return self
     */
    public function setActionBody($ActionBody)
    {
        if ($this->ActionType ==='open-url') {
            $this->ActionBody = $ActionBody;
        } else {
            $this->ActionBody = mb_substr($ActionBody, 0, 100);
        }

        return $this;
    }

    /**
     * Get the value of URL of image to place on top of background (if any). Can be a partially
     *
     * @return string
     */
    public function getImage()
    {
        return $this->Image;
    }

    /**
     * Set the value of URL of image to place on top of background (if any). Can be a partially
     *
     * @param string Image
     *
     * @return self
     */
    public function setImage($Image)
    {
        $this->Image = $Image;

        return $this;
    }

    /**
     * Get the value of Text to be displayed on the button. Can contain some HTML tags.
     *
     * @return string
     */
    public function getText()
    {
        return $this->Text;
    }

    /**
     * Set the value of Text to be displayed on the button. Can contain some HTML tags.
     *
     * @param string Text
     *
     * @return self
     */
    public function setText($Text)
    {
        if (!$Text) {
            return $this;
        }

        $this->Text = $Text;

        return $this;
    }

    /**
     * Get the value of Vertical alignment of the text
     *
     * @return string
     */
    public function getTextVAlign()
    {
        return $this->TextVAlign;
    }

    /**
     * Set the value of Vertical alignment of the text
     *
     * @param string TextVAlign
     *
     * @return self
     */
    public function setTextVAlign($TextVAlign)
    {
        if (!$TextVAlign || $TextVAlign!=="top"  || $TextVAlign!=="middle"  || $TextVAlign!=="bottom") {
            return $this;
        }
        $this->TextVAlign = $TextVAlign;

        return $this;
    }

    /**
     * Get the value of Horizontal align of the text
     *
     * @return string
     */
    public function getTextHAlign()
    {
        return $this->TextHAlign;
    }

    /**
     * Set the value of Horizontal align of the text
     *
     * @param string TextHAlign
     *
     * @return self
     */
    public function setTextHAlign($TextHAlign)
    {
        if (!$TextHAlign || $TextHAlign!=="left"  || $TextHAlign!=="center"  || $TextHAlign!=="right") {
            return $this;
        }
        $this->TextHAlign = $TextHAlign;

        return $this;
    }

    /**
     * Get the value of Text opacity. Range: 0-100
     *
     * @return integer
     */
    public function getTextOpacity()
    {
        return $this->TextOpacity;
    }

    /**
     * Set the value of Text opacity. Range: 0-100
     *
     * @param integer TextOpacity
     *
     * @return self
     */
    public function setTextOpacity($TextOpacity)
    {
        if (!$TextOpacity || $TextOpacity<0 || $TextOpacity>100) {
            return $this;
        }
        $this->TextOpacity = $TextOpacity;

        return $this;
    }

    /**
     * Get the value of Text size out of 3 available options: small, regular, large
     *
     * @return string
     */
    public function getTextSize()
    {
        
        return $this->TextSize;
    }

    /**
     * Set the value of Text size out of 3 available options: small, regular, large
     *
     * @param string TextSize
     *
     * @return self
     */
    public function setTextSize($TextSize)
    {
        if (!$TextSize || $TextSize!=="small"  || $TextSize!=="regular"  || $TextSize!=="large") {
            return $this;
        }
        $this->TextSize = $TextSize;

        return $this;
    }

    public function fromArray($incomArray)
    {
        return [
        'Columns' => $this->getColumns(),
        'Rows' => $this->getRows(),
        'BgColor' => $this->getBgColor(),
        'BgMediaType' => $this->getBgMediaType(),
        'BgMedia' => $this->getBgMedia(),
        'BgLoop' => $this->getBgLoop(),
        'ActionType' => $this->getActionType(),
        'ActionBody' => $this->getActionBody(),
        'Image' => $this->getImage(),
        'Text' => $this->getText(),
        'TextVAlign' => $this->getTextVAlign(),
        'TextHAlign' => $this->getTextHAlign(),
        'TextOpacity' => $this->getTextOpacity(),
        'TextSize' => $this->getTextSize(),
        'OpenURLType' => $this->getOpenURLType(),
        'OpenURLMediaType' => $this->getOpenURLMediaType()
        ];
    }

    public function isValid()
    {
        if (!$this->getActionBody()) {
            return false;
        }

        
        return true;
    }
}

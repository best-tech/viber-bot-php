<?php

namespace Viber\Api\Message;

use Viber\Api\Message;

/**
 * Rich_media message
 *
 * @author Novikov Bogdan <hcbogdan@gmail.com>
 */
class Rich_media extends Message
{
    /**
     * The text of the message
     *
     * @var string
     */
    protected $rich_media;
    protected $buttons;
   
    public function __construct()
    {
        $this->buttons = [];
        $this->rich_media = [];
        $this->rich_media['Type'] = 'rich_media';
        $this->rich_media['Buttons'] = [];
    }
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return Type::RICH_MEDIA;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $arrButtons = [];

        foreach ($this->buttons as $button){
            $arrButtons[] = $button->toApiArray();
        }
        $this->rich_media['Buttons'] = $arrButtons;

        return array_merge(parent::toArray(), [
            'rich_media' => $this->rich_media
        ]);
    }

    public function getButtonsGroupColumns()
    {
        return $this->rich_media['ButtonsGroupColumns'] ?? null;
    }

    public function getButtonsGroupRows()
    {
        return $this->rich_media['ButtonsGroupRows'] ?? null;
    }
    public function getBgColor()
    {
        return $this->rich_media['BgColor'] ?? null;
    }
    public function setBgColor($BgColor)
    {
        if (!$BgColor) {
            return;
        }
        $pregma = '/\#([a-fA-F]|[0-9]){3, 6}/';
        if (!preg_match($pregma, $BgColor)) {
            return $this;
        }
        $this->rich_media['BgColor'] = $BgColor;
    }
    public function setButtonsGroupColumns($ButtonsGroupColumns)
    {
        if ((int) $ButtonsGroupColumns >0 && (int) $ButtonsGroupColumns<6) {
            $this->rich_media['ButtonsGroupColumns'] = (int) $ButtonsGroupColumns;
        }
    }
    public function setButtonsGroupRows($ButtonsGroupRows)
    {
        if ((int) $ButtonsGroupRows >0 && (int) $ButtonsGroupRows<7) {
            $this->rich_media['ButtonsGroupRows'] = (int) $ButtonsGroupRows;
        }
    }
    
    public function getButtons()
    {
        return $this->buttons;
    }
    public function setButtons($buttons)
    {
        $this->buttons = $buttons;
    }
    public function getAlt_text()
    {
        return $this->rich_media['Alt_text'];
    }
    public function setAlt_text($Alt_text)
    {
        if (!$Alt_text) {
            return;
        }
        $this->rich_media['Alt_text'] = $Alt_text;
    }
    public function isValid()
    {
        if ($this->getButtonsGroupColumns()!==null && ($this->getButtonsGroupColumns()>6 || $this->getButtonsGroupColumns()<1)) {
            return false;
        }
        if ($this->getButtonsGroupRows()!==null && ($this->getButtonsGroupRows()>7 || $this->getButtonsGroupRows()<1)) {
            return false;
        }

        foreach ($this->getButtons() as $Button){
            if (!$Button->getActionBody()){
                return false;
            }
        }
        return true;
    }
}

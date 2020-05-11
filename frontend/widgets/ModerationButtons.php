<?php

namespace frontend\widgets;

use core\entities\User;
use yii\base\Widget;
use yii\helpers\Html;

class ModerationButtons extends Widget
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var array
     */
    private $defaultOptions = ['class' => 'btn btn-primary'];

    public function run()
    {
        return $this->renderButtons();
    }

    /**
     * @return string
     */
    private function renderButtons(): string
    {
        $panel = [];
        if ($this->user->isActive()) {
            $panel[] = $this->draft();
        } else {
            $panel[] = $this->activate();
        }
        $panel[] = $this->edit();
        $panel[] = $this->changePassword();
        $panel[] = $this->delete();
        return implode(' ', $panel);
    }

    /**
     * @return string
     */
    private function edit()
    {
        return $this->button('Редактировать', 'edit', $this->defaultOptions);
    }

    /**
     * @return string
     */
    private function changePassword()
    {
        return $this->button('Изменить пароль', 'change-password', $this->defaultOptions);
    }

    /**
     * @return string
     */
    private function activate()
    {
        return $this->button('Активировать', 'activate', $this->defaultOptions);
    }

    /**
     * @return string
     */
    private function draft()
    {
        return $this->button('В архив', 'draft', $this->defaultOptions);
    }

    /**
     * @return string
     */
    private function delete()
    {
        $options = [
            'class' => 'btn btn-danger',
            'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
            ],
        ];
        return $this->button('Удалить', 'delete', $options);
    }

    private function button(string $title, string $url, array $options): string
    {
        return Html::a($title, [$url, 'id' => $this->user->id], $options);
    }
}
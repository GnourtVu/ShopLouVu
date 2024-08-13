<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Helper
{
    public static function menu($menus, $parent_id = 0, $char = '')
    {
        $html = '';
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id == $parent_id) {
                $html .= '
                <tr>
                <th>' . $menu->id . '</th>
                <th>' . $char . $menu->name . '</th>
                <th>' . self::active($menu->active) . '</th>
                <th>' . $menu->updated_at . '</th>
                <th>
                <a href="/admin/menu/edit/' . $menu->id . '" style="margin-right: 10px;"><i class="fa-solid fa-pen-to-square"></i></a>
                <a href="#" onclick="removeRow(' . $menu->id . ',\'/admin/menu/destroy\')" ><i class="fa-solid fa-trash" style="color: red;"></i></a>
                </th>
                </tr>
                ';
                unset($menu[$key]);
                $html .= self::menu($menus, $menu->id, $char . '--');
            }
        }
        return $html;
    }
    public static function active($active = 0): string
    {
        return $active === 0 ? '<span class="btn btn-danger btn-xs">No</span>' : '<span class="btn btn-success btn-xs">YES</span>';
    }
    public static function menus($menus, $parent_id = 0): string
    {
        $html = '';
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id == $parent_id) {
                $html .= '
                <li>
                <a href="/categories/' . $menu->id . '-' . Str::slug($menu->name) . '.html">
                ' . $menu->name . '
                </a>';
                unset($menus[$key]);
                if (self::isChid($menus, $menu->id)) {
                    $html .= '<ul class="sub-menu">';
                    $html .= self::menus($menus, $menu->id);
                    $html .= '</ul>';
                }

                $html .=
                    '</li>
                ';
            }
        }
        return $html;
    }
    public static function isChid($menus, $id): bool
    {
        foreach ($menus as $menu) {
            if ($menu->parent_id == $id) {
                return true;
            }
        }
        return false;
    }
    public static function price($price = 0, $price_sale = 0)
    {
        if ($price != 0) return number_format($price);
        if ($price_sale != 0) return number_format($price_sale);
        return '<a href="/contact.html">Contact</a>';
    }
}

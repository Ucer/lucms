<?php

namespace App\Http\Controllers\Admin\Traits;

use App\Models\SystemConfig;

trait SystemConfigTrait
{
    public function getSystemConfig(array $flag, $parseRule = 'string')
    {
        $m_systemconfig = SystemConfig::whereIn('flag', $flag)->enableSearch('T')->select('id', 'flag', 'title', 'value')->get();
        if ($m_systemconfig) {
            $m_systemconfig = $m_systemconfig->toArray();
        }
        return $this->parseRule($m_systemconfig, $parseRule);
    }

    protected function parseRule($systemconfig, $rule)
    {
        switch ($rule) {
            case 'string':
                return $systemconfig->value;
        }
    }
}

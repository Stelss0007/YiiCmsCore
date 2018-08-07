<?php

namespace Stelssoft\YiiCmsCore;

use yii\web\UrlRule;

class CmsUrlRule extends UrlRule
{
    public function init()
    {
        if ($this->name === null) {
            $this->name = __CLASS__;
        }
    }

    public function createUrl($manager, $route, $params)
    {
        $routeParts = explode('/', $route);

        if (isset($routeParts[1]) && substr($routeParts[1], -6) === 'admin') {
            unset($routeParts[1]);
            $routeParts = array_merge(['admin'], $routeParts);
            $url = implode('/', $routeParts);

            if (!empty($params) && ($query = http_build_query($params)) !== '') {
                $url .= '?' . $query;
            }

            return $url;
        }

        return false;
    }

    public function parseRequest($manager, $request)
    {
//        $pathInfo = $request->getPathInfo();
//        echo $pathInfo;
//
//        if (preg_match('%^admin/(\w+)(/(\w+))?$%', $pathInfo, $matches)) {
//
//            // check $matches[1] and $matches[3] to see
//            // if they match a manufacturer and a model in the database
//            // If so, set $params['manufacturer'] and/or $params['model']
//            // and return ['car/index', $params]
//
//            return [$matches[1] . '/' . $matches[1] . '-admin/' . $matches[3], []];
//        }

        return false;  // это правило не подходит
    }
}

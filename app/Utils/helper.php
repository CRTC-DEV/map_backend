<?php

use Illuminate\Support\Facades\Request;

function connect_businesses_log($log)
{
    file_put_contents(base_path() . '/storage/logs/connect_businesses_log.log', date("r") . ":\n" . $log . "\n---\n", FILE_APPEND);
}

if (!function_exists('guarded_route')) {
    /**
     * Generate a route or URL based on the user's guard.
     *
     * @param string $userRoute
     * @param string $adminRoute
     * @param array $params
     * @return string
     */
    function guarded_route($userRoute, $adminRoute, $params = [])
    {
        if (auth()->guard('admin')->check()) {
            return route($adminRoute, $params); // Ưu tiên admin
        }
        
        if (auth()->guard('user')->check()) {
            return route($userRoute, $params); // Nếu không phải admin, kiểm tra user
        }

        return '#'; // Mặc định, nếu không đăng nhập guard nào
    }
}

if (!function_exists('guarded_url')) {
    /**
     * Generate a URL based on the user's guard.
     *
     * @param string $userUrl
     * @param string $adminUrl
     * @return string
     */
    function guarded_url($userUrl, $adminUrl)
    {
        if (auth()->guard('admin')->check()) {
            return url($adminUrl); // Ưu tiên admin
        }
        
        if (auth()->guard('user')->check()) {
            return url($userUrl); // Nếu không phải admin, kiểm tra user
        }

        return '#'; // Mặc định, nếu không đăng nhập guard nào
    }
}

if (!function_exists('guarded_redirect')) {
    /**
     * Redirect based on guard.
     *
     * @param string $userRoute
     * @param string $adminRoute
     * @param array $params
     * @return \Illuminate\Http\RedirectResponse
     */
    function guarded_redirect($userRoute, $adminRoute, $params = [])
    {
        if (auth()->guard('admin')->check()) {
            return redirect()->route($adminRoute, $params);
        }

        if (auth()->guard('user')->check()) {
            return redirect()->route($userRoute, $params);
        }

        return redirect()->back(); // Fallback nếu không có guard nào
    }
}
function menuCollapseState($menu)
{
    $list_tab = [];

    switch ($menu) {
        case 'components':
            $list_tab = [
                'text-content','admin.text-content',
                'languages', 'admin.languages',
                't2-location',
                'translations', 'admin.translations',
                'admin.title','admin.description',
            ];
            break;
            
        case 'item':
            $list_tab = [
                'item-type',
                'item-title',
                'item-description'
            ];
            break;
            
        case 'map':
            $list_tab = [
                'map-item',
                'route-map-item',
                'route-map-item-detail',
                'signage-mapitem'
            ];
            break;

        case 'search':
            $list_tab = [
                'group-search',
                'group-search-map-item'
            ];
            break;

         case 'banner':
            $list_tab = [
                'banner-adv',
                'banner-adv-device-touch',
            ];
            break;

        case 'signage':
            $list_tab = [
                'signage',
                'signage-devicetouch',
                'device-touch-screen'
            ];
            break;

        case 'groupfunction':
            $list_tab = [
                'groupfunction',
                'groupfunction-devicetouch',
                'mainfunction',
                'group-mainfunction',
            ];
            break;
        
        case 'event':
            $list_tab = [
                'event',
                'faq',
                'faq-type',
                'contact-number',
                'contact-number-type',
            ];
            break;

        case 'user':
            $list_tab = [
                'user','admin.web'
            ];
            break;
        
        case 'sidebar-menu':
            $list_tab = [
                'admin.topmenu','admin.submenu','admin.submenuontopmenu'
            ];
            break;
            
        case 'connect-business':
            $list_tab = [
                'admin.connect.business'
            ];
            break;
    }

    return in_array(Request::route()->getName(), $list_tab) ? 'show' : 'hide';
}

function uploadImage($image, $folder)
{
    if (!$image instanceof \Illuminate\Http\UploadedFile) {
        return $image; // Return the old path if not a file
    }
    
    $image_name = time() . '-' . $image->getClientOriginalName();
    $path = $image->storeAs($folder, $image_name, 'public');
    
    return $path;
}
function uploadMultipleImages($images, $folder, $maxFileSize = 2048) // $maxFileSize in KB
{
    $uploadedPaths = [];
    $path = 'storage/' . $folder . '/';
    $dir = public_path($path);

    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    foreach ($images as $image) {
        if ($image->getSize() > $maxFileSize * 1024) {
            throw new \Exception('File size exceeds the maximum limit of ' . $maxFileSize . ' KB.');
        }

        $imageName = time() . '-' . $image->getClientOriginalName();
        $image->storeAs($folder, $imageName, 'public');
        $imgPath = $path . $imageName;

        $uploadedPaths[] = $imgPath;
    }

    return $uploadedPaths;
}



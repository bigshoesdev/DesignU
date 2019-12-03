<?php

namespace App\Http\Controllers\ShopManager;

use App\BrandDesignSource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Brand;
use App\BrandSNS;
use Sentinel;

class BrandManageController extends Controller
{
    public function uploadMainImg(Request $req)
    {
        $data = array();

        if ($req->hasFile('img')) {
            $file = $req->file('img');
            $user = Sentinel::getUser();
            if ($user->getBrand()) {
                $brand = $user->getBrand();

                $folderPath = 'uploads/brand/' . $brand->id . '/';
                $fileName = time() . '.' . $file->getClientOriginalExtension();

                if ($req->get('type') > 0) {
                    if ($brand->web_img_url != "")
                        unlink($brand->web_img_url);
                } else {
                    if ($brand->mobile_img_url != "")
                        unlink($brand->mobile_img_url);
                }

                $file->move($folderPath, $fileName);
                if ($req->get('type') > 0) {
                    $brand->web_img_url = $folderPath . $fileName;
                } else {
                    $brand->mobile_img_url = $folderPath . $fileName;
                }

                $brand->save();
            } else {
                $brand = new Brand;
                $brand->user_id = $user->id;
                $brand->save();

                $fileName = time() . '.' . $file->getClientOriginalExtension();

                $folderPath = 'uploads/brand/' . $brand->id . '/';
                if (!\File::exists($folderPath)) {
                    \File::makeDirectory($folderPath);
                }
                $file->move($folderPath, $fileName);

                if ($req->get('type') > 0) {
                    $brand->web_img_url = $folderPath . $fileName;
                } else {
                    $brand->mobile_img_url = $folderPath . $fileName;
                }

                $brand->save();
            }

            $data['success'] = true;
            $data['brand'] = $brand;

            $this->checkBrandForm();

            return json_encode($data);
        }

        $data['success'] = false;

        return json_encode($data);
    }

    public function uploadLogoImg(Request $req)
    {
        $data = array();

        if ($req->hasFile('img')) {
            $file = $req->file('img');
            $user = Sentinel::getUser();
            if ($user->getBrand()) {
                $brand = $user->getBrand();

                $folderPath = 'uploads/brand/' . $brand->id . '/';
                $fileName = time() . '.' . $file->getClientOriginalExtension();

                if ($brand->pic != "")
                    unlink($brand->pic);

                $file->move($folderPath, $fileName);
                $brand->pic = $folderPath . $fileName;

                $brand->save();
            } else {
                $brand = new Brand;
                $brand->user_id = $user->id;
                $brand->save();

                $fileName = time() . '.' . $file->getClientOriginalExtension();

                $folderPath = 'uploads/brand/' . $brand->id . '/';
                if (!\File::exists($folderPath)) {
                    \File::makeDirectory($folderPath);
                }
                $file->move($folderPath, $fileName);

                $brand->pic = $folderPath . $fileName;

                $brand->save();
            }

            $data['success'] = true;
            $data['brand'] = $brand;

            $this->checkBrandForm();

            return json_encode($data);
        }

        $data['success'] = false;

        return json_encode($data);
    }

    public function uploadDesignSource(Request $req)
    {
        if ($req->file('img')) {

            $user = Sentinel::getUser();
            if ($user->getBrand()) {
                $brand = $user->getBrand();
            } else {
                $brand = new Brand();
                $brand->user_id = $user->id;
                $brand->save();
            }

            if ($brand) {
                if ($req->file('img')) {
                    $index = 0;

                    foreach ($req->file('img') as $file) {
                        if (!empty($file)) {
                            $fileName = time() . '-' . $index++ . '.' . $file->getClientOriginalExtension();

                            $folderPath = 'uploads/designsource/' . $brand->id;
                            if (!\File::exists($folderPath)) {
                                \File::makeDirectory($folderPath);
                            }

                            try {
                                $file->move($folderPath, $fileName);
                            } catch (Exception $e) {
                            }

                            $designSource = new BrandDesignSource();
                            $designSource->url = $folderPath . "/" . $fileName;
                            $designSource->price = 0;
                            $designSource->brand_id = $brand->id;
                            $designSource->save();
                        }
                    }

                    $this->checkBrandForm();
                    return json_encode([
                        'success' => true,
                        'designSources' => $brand->getDesignSources()->get()
                    ]);
                }
            }
        }

        return json_encode([
            'success' => false,
        ]);

    }

    public function saveBrandTip(Request $req)
    {
        $user = Sentinel::getUser();
        if ($user->getBrand()) {
            $brand = $user->getBrand();
        } else {
            $brand = new Brand;
            $brand->user = $user->id;
            $brand->save();
        }

        $brand->tip = json_encode($req->tip);

        $brand->save();

        $data = array();
        $data['success'] = true;
        $data['brand'] = $brand;
        $this->checkBrandForm();
        return json_encode($data);
    }

    public function saveShopInfo(Request $req)
    {
        $user = Sentinel::getUser();
        if ($user->getBrand()) {
            $brand = $user->getBrand();
        } else {
            $brand = new Brand;
            $brand->user_id = $user->id;
            $brand->save();
        }

        $brand->brand_id = $req->get('id');
        $brand->company = $req->get('company');
        $brand->country = $req->get('country');
        $brand->hp = $req->get('hp');
        $brand->zipcode = $req->get('zipcode');
        $brand->address = $req->get('address');

        $brand->save();

        $data = array();
        $data['success'] = true;
        $data['brand'] = $brand;

        $this->checkBrandForm();
        return json_encode($data);
    }

    public function saveSNS(Request $req)
    {
        $user = Sentinel::getUser();
        if ($user->getBrand()) {
            $brand = $user->getBrand();
        } else {
            $brand = new Brand;
            $brand->user_id = $user->id;
            $brand->save();
        }

        $brandSNS = new BrandSNS;
        $brandSNS->sns_type = $req->get('snsType');
        $brandSNS->sns_id = $req->get('snsID');
        $brandSNS->brand_id = $brand->id;
        $brandSNS->save();

        $data = array();
        $data['success'] = true;
        $data['brandSNSs'] = $brand->getBrandSNSs()->get();

        $this->checkBrandForm();
        return json_encode($data);
    }

    public function deleteSNS(Request $req)
    {
        $brandSNS = BrandSNS::find($req->get('id'));

        $brandSNS->delete();

        $user = Sentinel::getUser();
        $brand = $user->getBrand();

        $data = array();
        $data['success'] = true;
        $data['brandSNSs'] = $brand->getBrandSNSs()->get();

        return json_encode($data);
    }

    public function saveDesignSourcePrice(Request $req)
    {
        $designSource = BrandDesignSource::find($req->get('id'));
        $designSource->price = $req->get('price');
        $designSource->status = 1;

        $designSource->save();

        $user = Sentinel::getUser();
        $brand = $user->getBrand();
        $data['success'] = true;
        $data['designSources'] = $brand->getDesignSources()->get();

        $this->checkBrandForm();
        return json_encode($data);
    }

    public function deleteDesignSource(Request $req)
    {
        $designSource = BrandDesignSource::find($req->get('id'));
        $designSource->status = 0;
        $designSource->save();

        $user = Sentinel::getUser();
        $brand = $user->getBrand();
        $data['success'] = true;
        $data['designSources'] = $brand->getDesignSources()->get();

        return json_encode($data);
    }

    public function getBrandInfo()
    {
        $user = Sentinel::getUser();

        $brand = null;

        $data = array();
        $data['brand'] = null;
        $data['designSources'] = array();

        if ($user->getBrand()) {
            $brand = $user->getBrand();
            $data['brand'] = $brand;
            $data['designSources'] = $brand->getDesignSources()->get();
            $data['brandSNSs'] = $brand->getBrandSNSs()->get();
        }

        return json_encode($data);
    }

    public function checkBrandForm()
    {
        $brand = Sentinel::getUser()->getBrand();

        $isComplete = true;

        if ($brand) {
            if ($brand->mobile_img_url == "" || $brand->mobile_img_url == "" || $brand->tip == "" || $brand->pic == "")
                $isComplete = false;
            if ($brand->brand_id == "" || $brand->company == "" || $brand->country == "" || $brand->hp == "" || $brand->zipcode == "" || $brand->address == "")
                $isComplete = false;
            if (count($brand->getBrandSNSs()->get()) == 0) {
                $isComplete = false;
            }
            if ($isComplete)
                $brand->is_complete = 1;
            else
                $brand->is_complete = 0;
            $brand->save();
        }
    }
}
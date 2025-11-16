<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\CompanyEnum;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyVersion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function add(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:256',
            'edrpou' => 'required|string|max:10',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation fails!',
                'details' => $validator->errors(),
            ], 400);
        }

        $company = Company::where('edrpou', $request['edrpou'])->first();

        if (!$company) {
            $newCompany = Company::create($request->all());
            $newVersion = CompanyVersion::create([
                'company_id' => $newCompany->id,
                'version' => 1,
                'data' => serialize($request->all()),
            ]);

            return response()->json([
                'status' => CompanyEnum::CREATED,
                'company_id' => $newCompany->id,
                'version' => $newVersion->version
            ]);
        } else {
            $company->name = $request['name'];
            $company->edrpou = $request['edrpou'];
            $company->address = $request['address'];
            $companyVersion = $company->versions()->latest()->first();

            if (!$company->isDirty())
            {
                return response()->json([
                    'status' => CompanyEnum::DUPLICATE,
                    'company_id' => $company->id,
                    'version' => $companyVersion->version,
                ]);
            } else {
                CompanyVersion::create([
                    'company_id' => $company->id,
                    'version' => $companyVersion->version + 1,
                    'data' => serialize($request->all()),
                ]);

                $company->save();

                return response()->json([
                    'status' => CompanyEnum::UPDATED,
                    'company_id' => $company->id,
                    'version' => $companyVersion->version + 1
                ]);
            }
        }
    }

    public function getCompanyVersions(string $edrpou, Request $request): JsonResponse
    {
        $company = Company::where('edrpou', $request['edrpou'])->first();

        if (!$company) {
            return response()->json(['message' => 'No such company with provided EDRPOU.']);
        }

        return response()->json($company->versions()->select('version', 'data', 'updated_at')->orderBy('version','DESC')->get());
    }
}

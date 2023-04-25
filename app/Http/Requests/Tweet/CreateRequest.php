<?php

namespace App\Http\Requests\Tweet;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'tweet' => 'required|max:140', // つぶやきは必須、140文字以内
            'images' => 'array|max:4', // 画像は配列、4枚まで
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像は必須、jpeg,png,jpg,gifのみ、2MBまで
        ];
    }

    // Requestクラスのuser関数で今自分がログインしているユーザーの情報を取得
    public function userId(): int
    {
        return $this->user()->id;
    }

    // フォームから送信されたデータをDBに反映
    public function tweet(): string
    {
        return $this->input('tweet');
    }

    // フォームから送信された画像を取得
    public function images(): array
    {
        return $this->file('images', []);
    }

    // フォームから送信された画像を取得
    public function originalTweetId(): int
    {
        return (int) $this->route('originalTweetId');
    }
}

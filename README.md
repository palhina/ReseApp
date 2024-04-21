# 飲食店予約サービス Rese

## アプリケーション名  
**Rese(リーズ)**

## 使用画面のイメージ  
### ユーザーアカウント  
![user](https://github.com/palhina/ReseApp/assets/129643430/ca7249a0-70ab-4553-bc14-6febb47a8caa)  
  
### 店舗代表者アカウント  
![manager](https://github.com/palhina/ReseApp/assets/129643430/e702cd4a-fb8a-4c05-8433-ea1ed49c6e71)  
  
### 管理者アカウント  
![admin](https://github.com/palhina/ReseApp/assets/129643430/f3db2a59-2f5f-4fbe-922c-dc8dcea7231f)  

  
  
## 作成した目的  
ある企業のグループ会社から、自社で飲食店予約サービスを持ちたいと要望があったため  

## アプリケーションURL  
GithubURL：https://github.com/palhina/ReseApp.git  
http://rese-aws-launch.shop    

## ほかのレポジトリ  
今回はなし  

## 機能一覧  
- 一般ユーザー関連
  - アカウント新規登録
  - ログイン・ログアウト機能
  - 初回ログイン成功時メールによる二要素認証
  - 飲食店一覧表示
  - 飲食店詳細情報表示
  - 飲食店お気に入り追加・削除
  - 飲食店予約・変更・予約情報削除
  - エリア、ジャンル、店名検索
  - stripeによる決済
  - 予約詳細情報QRコード表示
  - 口コミ作成
  - 口コミ編集・削除(ログインユーザー自身のもののみ)
  - 口コミ一覧表示
  - 飲食店一覧ページソート機能(ランダム・平均評価の昇/降順)
- 店舗代表者関連
  - ログイン・ログアウト機能
  - 作成した店舗一覧表示
  - 店舗情報の新規作成・編集
  - 予約情報一覧・詳細表示
- 管理者関連
  - 店舗代表者新規作成
  - メール送信機能(利用者全員に対して)
  - 口コミ削除(すべての口コミ)
  - CSVファイルによる店舗新規登録
- その他
  - リマインダー機能(予約当日朝8時に、ユーザーへメール送信)   
    
## 使用技術(実行環境)  
- フロントエンド  
  - HTML/CSS  
- バックエンド  
  - PHP 8.1.2  
  - Laravel 9.52.16  
  - Composer 2.6.2  
  - PHPUnit 9.5.10  
- ミドルウェア  
  - Nginx 1.21.1  
  - MySQL 8.0.35/PHPMyAdmin   
- インフラ  
  - Docker 24.0.5 
  - AWS(IAM,VPC,EC2,RDS,S3,Route53)  
  
## テーブル設計  
![テーブル設計図](https://github.com/palhina/ReseApp/assets/129643430/b1f7b173-627a-40fa-b578-fcedef245fa4)  

## ER図  
![ER図](https://github.com/palhina/ReseApp/assets/129643430/e3dc8e1a-8139-4498-a350-ba9d5365626e)  


## 環境構築  

* インストール手順

１．プロジェクトを保存したいディレクトリに移動し、その後Githubからリポジトリをクローンします：

        $git clone https://github.com/palhina/ReseApp.git
        
その後リポジトリのディレクトリに移動します：

        $cd ReseApp

２．Dockerを使用し、アプリケーションを起動します：
	
         $docker-compose up -d --build

３．Laravelのパッケージをインストールするために、phpコンテナ内にログインします：
	
          $ docker-compose exec php bash

４．コンテナ内でComposerをインストールします：
	
         $composer install --ignore-platform-req=ext-gd

５．”.env”ファイルを作成し、データベース名、ユーザ名、パスワードなどの必要な環境変数を設定します：
	
         $cp .env.example .env

その後“.env”ファイルを編集し、必要な設定を追加、編集します。

６．アプリケーションキーを作成します：

        $php artisan key:generate

７．データベースのマイグレーションを実行します：

        $php artisan migrate
	
８．必要に応じて、ダミーデータの作成を行ってください：

        $php artisan db:seed

９．画像のアップロードを行うため、シンボリックリンクを作成します：

        $php artisan storage:link
  
  
**このプロジェクトでは、AWS S3を利用して画像アップロード機能を実装しています。**  
  
以下の手順でAWS S3へのアクセスを設定してください。  
  
１． AWS IAM ユーザーの作成  
	AWS IAMコンソールで、S3へのアクセス権限を付与した新しいIAMユーザーを作成してください。  
	IAMユーザーのアクセスキーとシークレットキーの取得を行ってください。    
  
２． S3 バケットの作成  
	AWS S3コンソールで、画像をアップロードするための新しいS3バケットを作成してください。  
  
３． ”.env”ファイルにおいて、必要な環境変数を設定します  
  
      AWS_ACCESS_KEY_ID= アクセスキー  
      AWS_SECRET_ACCESS_KEY=シークレットアクセスキー  
      AWS_DEFAULT_REGION=S3バケットを作成したリージョン名  
      AWS_BUCKET=S3バケット名  


* アプリケーションはデフォルトで http://localhost でアクセスできます。

* MySQLはデフォルトで http://localhost:8080 でアクセスできます。
  
* ローカル環境でのメールの検証については、Mailtrapなどをご利用いただき.envファイルで環境設定を行ってください。
    
* エラーが発生する場合、$ sudo chmod -R 777 *コマンドにて権限変更を行ってみてください。

* PHP Unitを用いてテストを作成しています。その際はコンテナ内にて以下のコマンドを実行してください。

         $php artisan test
  
* ローカル環境においてリマインドメール機能を検証する場合、以下のコマンドでタスクスケジューラーを起動してください。  
	
         $php artisan schedule:work
	

## 追記  
**CSVファイルについて**
* 管理者が読み込むCSVファイルは、1行目に「地域,ジャンル,店舗名,画像,店舗概要」などと入力してください。  
  必ず2行目以降から、店舗情報を上記の順番に「,」で区切り入力してください。(設定上、1行目に入れた項目は読み込みません。)  
  文章内に「,」を用いる場合(価格など)は、文章全体を「"　"」で囲ってください。
* 画像登録に用いるURLは、必ず　http://　または　https://　から始まり、.jpg (.jpeg) または.pngで終わるものを設定してください。  
  
**ダミーデータについて**  
* ユーザーデータ(usersテーブル)
ユーザー名test(メールアドレス、以下同様：111@mail.com)、test2(222@mail.com)を作成しています。  
パスワードはいずれも「1234567890」。  
testアカウントのみ二要素認証済としています。  
* お気に入り(favoritesテーブル)、予約情報(reservationsテーブル)、口コミ(ratingsテーブル)    
  いずれもユーザー名testにおいて、適当に作成しております。  
* 店舗情報(shopsテーブル)  
  20店舗の店舗名・画像・エリア・ジャンル・コメントおよび店舗作成者の登録をしております。  
  店舗作成者は任意に設定を行いました。  
* エリア(areasテーブル)、ジャンル(genresテーブル)
  エリアは3都道府県、ジャンルは5つ登録しています。  
* 管理者データ(adminsテーブル)    
  管理者名admin_test、メールアドレスadmin1@mail.com、パスワードは「1234567890」で設定しています。
* 店舗代表者(managersテーブル)  
  店舗代表者名manager1(メールアドレス、以下同様：manager1@mail.com)、manager2(manager2@mail.com)を作成しています。  
  パスワードはいずれも「1234567890」です。  

**決済機能について**  
テスト環境下で作成のため、実際のクレジットカードを用いた決済はできません。  
https://stripe.com/docs/testing  を参考に、架空のテスト用クレジットカードを使用して下さい。   

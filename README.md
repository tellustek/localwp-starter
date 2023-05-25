<a name="readme-top"></a>
# Welcome to LocalWP Starter
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]

本 repo 是提供給 LocalWP 新建立本地端專案使用, 可以方便的搭配 github template 幫 LocalWP 增加版控.
<br><br>

## 事前準備
此專案需搭配 [LocalWP][localwp-url] 使用. deployment需安裝 [NodeJS][nodejs-url] 與 [AWS-CDK][aws-cdk-url]. 如果執行環境為 Windows, 建議安裝 Git for Windows 時勾選 `Add a Git Bash Profile to Windows Terminal`
<br><br>

## USAGE
### 新建專案
如果沒有 template 可以使用請先 fork 此 repo, 並且打開 github settings 將其設定為 template.<br>
再使用此 template 開啟一個新的 repo, 使用 code -> download zip 下載打包檔, 就可以用此 zip 檔案來建立 LocalWP 新專案.
<br><br>

### 增加版控
專案建立完成之後
1. 點擊 `Open site shell` 開啟終端機 (Windows 請使用 git bash 作為終端機工具進行開啟)
2. 輸入 `cd ../..` 回到專案根目錄
3. 輸入 `git clone <NEW_PROJECT_REPO_URL> repo` 將github上建立好的專案 repo clone 至 LocalWP 專案根目錄的 `repo` 或是任何你喜歡的名字資料夾中
4. 進入步驟三 clone 完成的資料夾中執行 `./link.sh`<br>
   此步驟將會刪除原 LocalWP 專案建立的 `plugins` 與 `themes` 資料夾, 並建立軟聯結至 repo 中相對應的資料夾

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## DEPLOYMENT
搭配 AWS CDK 進行發佈, 實作中...

### Useful commands

* `npm run build`   compile typescript to js
* `npm run watch`   watch for changes and compile
* `npm run test`    perform the jest unit tests
* `cdk deploy`      deploy this stack to your default AWS account/region
* `cdk diff`        compare deployed stack with current state
* `cdk synth`       emits the synthesized CloudFormation template

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- LICENSE -->
## License
MIT License.
<br><br>

<!-- ROADMAP -->
## ROADMAP
- [x] 完成本地開發搭配
- [x] 基本還原功能
- [x] Akeeba還原測試
- [ ] Deployment scripts

任何問題或是討論都歡迎在[issues][issues-url]提出
<br><br>

<!-- CONTACT -->
## CONTACT
Shingo - [@0xShingo](https://twitter.com/0xShingo) - shingo@tellustek.com

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/tellustek/localwp-starter.svg?style=for-the-badge
[contributors-url]: https://github.com/tellustek/localwp-starter/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/tellustek/localwp-starter.svg?style=for-the-badge
[forks-url]: https://github.com/tellustek/localwp-starter/network/members

[stars-shield]: https://img.shields.io/github/stars/tellustek/localwp-starter.svg?style=for-the-badge
[stars-url]: https://github.com/tellustek/localwp-starter/stargazers
[issues-shield]: https://img.shields.io/github/issues/tellustek/localwp-starter.svg?style=for-the-badge
[issues-url]: https://github.com/tellustek/localwp-starter/issues
[license-shield]: https://img.shields.io/github/license/tellustek/localwp-starter.svg?style=for-the-badge
[license-url]: https://github.com/tellustek/localwp-starter/blob/master/LICENSE.txt
[localwp-url]: https://localwp.com/
[issues-url]: https://github.com/tellustek/localwp-starter/issues
[nodejs-url]: https://nodejs.org/
[aws-cdk-url]: https://aws.amazon.com/cdk/
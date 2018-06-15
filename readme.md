# 先锋市场

[![Build Status](https://travis-ci.org/NEUP-Net-Depart/NEUP-FleaMarket.svg?branch=master)](https://travis-ci.org/NEUP-Net-Depart/NEUP-FleaMarket)
[![Coverage Status](https://coveralls.io/repos/github/NEUP-Net-Depart/NEUP-FleaMarket/badge.svg?branch=master)](https://coveralls.io/github/NEUP-Net-Depart/NEUP-FleaMarket?branch=master)

由先锋网络中心设计、开发和运营的先锋市场，
前身是先锋论坛的「跳蚤市场」板块。
独立的跳蚤市场自 2016 年开始设计，
2017 年 6 月公测，正式定名为「先锋市场」。

2017 年 10 月释出的 v1.0 版本，
基于 Laravel PHP 框架构建。
前端大部分使用 Blade 模板直接渲染，
部分页面使用 Vue.js 来加载。
异步消息系统（[源代码](https://github.com/NEUP-Net-Depart/email-daemon)）
包括邮件、微信、短信消息推送，
使用 Golang 编写。

### Code Style Guide

**PHP：**

**请严格按照 [PSR-2](https://www.php-fig.org/psr/psr-2/) 和 [PSR-12](https://github.com/php-fig/fig-standards/blob/master/proposed/extended-coding-style-guide.md) 要求格式化代码**

> Code MUST use an indent of 4 spaces, and MUST NOT use tabs for indenting.

> The PHP constants true, false, and null MUST be in lower case.

> The keyword elseif SHOULD be used instead of else if so that all control
  keywords look like single words.
  
> All binary and ternary (but not unary) operators MUST be preceded and followed by at least one space. This includes all arithmetic, comparison, assignment, bitwise, logical (excluding ! which is unary), string concatenation, type operators, trait operators (insteadof and as), and the single pipe operator (e.g. ExceptionType1 | ExceptionType2 $e).

**HTML(Blade), CSS(SASS, SCSS, LESS), JavaScript(TypeScript)：**

**约定按照 [Google HTML/CSS Style Guide](https://google.github.io/styleguide/htmlcssguide.html) 格式化代码**

> Indent by 2 spaces at a time.
>
> Don’t use tabs or mix tabs and spaces for indentation.

### 依赖环境
主程序：PHP 5.6+，Mysql；
异步消息系统：Mysql，RabbitMQ

### 鸣谢
感谢东大小秘书提供的微信消息接口！

### 捐助我们
短信消息通知给我们带来了不少的开支，
如果你觉得这一功能给你带来了便利，欢迎捐助！

Made with ❤ by NEUP Net Department
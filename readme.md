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
部分页面使用 Vuejs 来加载。
异步消息系统（[源代码](https://github.com/NEUP-Net-Depart/email-daemon)）
包括邮件系统，微信、短信消息推送，
使用 Golang 编写。

感谢东大小秘书提供的微信消息接口！

短信消息通知给我们带来了不少的开支，
如果你觉得这一功能给你带来了便利，欢迎捐助！
（捐助渠道还没想好，先准备好捐助的心情吧OvO）

依赖的环境：
主程序：PHP 5.6+，Mysql；
异步消息系统：Mysql，RabbitMQ

Made with ❤ by NEUP Net Department

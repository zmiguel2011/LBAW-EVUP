# EVUP
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](LICENSE)
[![Uporto FEUP](https://img.shields.io/badge/UPorto-FEUP-brown)](FEUP)

`EVUP is an events management web platform built specifically for students and organizations at University of Porto`

### Project Grade: 18.2/20

## Team

- Daniela Tomás, up202004946@edu.fc.up.pt
- Hugo Almeida, up202006814@edu.fe.up.pt
- José Miguel Isidro, up202006485@edu.fe.up.pt
- Sara Moreira Reis, up202005388@edu.fe.up.pt

## Artefacts

The artefacts can be found [here](https://github.com/zmiguel2011/LBAW-EVUP/wiki)

### 1. Installation

Final version of the source code [here](https://github.com/zmiguel2011/LBAW-EVUP/tree/main/evup)
```
docker run -it -p 8000:80 --name=lbaw2252 -e DB_DATABASE="lbaw2252" -e DB_SCHEMA="lbaw2252" -e DB_USERNAME="lbaw2252" -e DB_PASSWORD=[PASS] git.fe.up.pt:5050/lbaw/lbaw2223/lbaw2252
```

### 2. Usage

> URL to the product: https://lbaw2252.lbaw.fe.up.pt/

#### 2.1. Administration Credentials

> Administration URL: https://lbaw2252.lbaw.fe.up.pt/admin

| Email | Password |
|-------|----------|
| admin@evup.com | 1234 |

#### 2.2. User Credentials

| Type | Email | Password |
|------|-------|----------|
| basic account | user@evup.com | 1234 |
| event organizer | organizer@evup.com | 1234 |
| blocked account | blocked@evup.com | 1234 |

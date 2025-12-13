# 📘 LUXPRIME — BACKLOG MÉTIER (VERSION FONDATION)

---

## 🧍 UTILISATEUR & COMPTES

### ✅ US-01 — Création automatique des 2 comptes
**En tant que système**,  
je veux qu’un utilisateur possède **automatiquement exactement 2 comptes**,  
afin de garantir le modèle bancaire LuxPrime.

- OFFSHORE  
- OFFSHORE_PLUS  

✅ Testé  
✅ Implémenté  

---

### ✅ US-02 — Numéro de compte unique sur 11 chiffres
**En tant que système**,  
je veux que chaque compte ait un `num_compte` :
- unique  
- sur **11 chiffres**  
- complété par des **zéros à gauche si nécessaire**

✅ Testé  
✅ Implémenté  

---

### ✅ US-03 — IBAN imposé par type de compte
**En tant que système**,  
je veux que l’IBAN soit :

- `LU89 0061 1014 0372 1090` pour **OFFSHORE**
- `LU89 0061 1014 0372 1092` pour **OFFSHORE_PLUS**

✅ Testé  
✅ Implémenté  

---

## 💰 SOLDE & SÉCURITÉ FINANCIÈRE

### ✅ US-04 — Solde jamais négatif
**En tant que système**,  
je veux empêcher toute opération qui rendrait un solde négatif,  
afin de sécuriser la logique bancaire.

✅ Testé  
✅ Implémenté dans `Account::applyOperation()`

---

## 🔐 STATUT DES COMPTES

### ✅ US-05 — Statut modifiable uniquement par un ADMIN
**En tant qu’admin**,  
je veux pouvoir bloquer ou activer un compte,  
afin de contrôler les risques.

✅ Testé  
✅ Implémenté  

---

### ✅ US-06 — Un utilisateur ne peut pas modifier le statut
**En tant qu’utilisateur**,  
je ne peux pas modifier le statut d’un compte.

✅ Testé  
✅ Implémenté  

---

## 🔄 VIREMENTS

### ✅ US-07 — Virement atomique
**En tant que système**,  
je veux qu’un virement soit **atomique** :
- soit débit + crédit réussissent
- soit rien ne s’applique

✅ Testé  
✅ Implémenté  

---

### ✅ US-08 — Virement impossible si solde insuffisant
**En tant que système**,  
je veux bloquer tout virement dont le montant dépasse le solde source.

✅ Testé  
✅ Implémenté  

---

### ✅ US-09 — Virement impossible si un compte est bloqué
**En tant que système**,  
je veux empêcher tout virement :

- si le compte source est `BLOCKED`
- ou si le compte cible est `BLOCKED`

✅ Testé  
✅ Implémenté  

---

## 📊 DASHBOARD

### ✅ US-10 — Dashboard multi-comptes
**En tant qu’utilisateur**,  
je veux voir :

- mes **2 comptes**
- leurs **soldes**
- leurs **historiques**
- leurs **totaux positifs et négatifs**

✅ Testé  
✅ Implémenté  

---

### ✅ US-11 — Blocage visuel en cas de solde invalide
**En tant que système**,  
je veux afficher une **erreur visible** si une opération invalide est rencontrée.

✅ Testé  
✅ Implémenté  

---

## 🧪 QUALITÉ & TESTS

### ✅ US-12 — Simulation de BDD corrompue
**En tant que testeur**,  
je veux pouvoir simuler des données invalides pour tester la robustesse.

✅ Via override  
✅ En place  

---

### ✅ US-13 — Protection par TDD obligatoire
**En tant qu’architecte**,  
je veux que toute règle métier critique soit couverte par un test.

✅ Respecté jusqu’ici  

---


### ⏳ US-14 — Historique des virements (traçabilité)
Journalisation de chaque virement avec :
- compte source
- compte cible
- montant
- date
- statut (SUCCÈS / REFUSÉ)


# ⏳ BACKLOG À VENIR
---

### ⏳ US-15 — Filtrage des virements par compte
Afficher l’historique :
- par compte
- par période

---

### ⏳ US-16 — Rôles utilisateur (USER / ADMIN)
Gestion stricte des permissions :
- USER
- ADMIN

---

### ⏳ US-17 — Authentification sécurisée
Connexion par :
- email
- mot de passe sécurisé

---

### ⏳ US-18 — Virements inter-utilisateurs
Possibilité de virer vers les comptes d’autres utilisateurs.

---

### ⏳ US-19 — Journal de conformité (Audit)
Historique immuable pour :
- conformité bancaire
- traçabilité admin
- contrôle réglementaire

---

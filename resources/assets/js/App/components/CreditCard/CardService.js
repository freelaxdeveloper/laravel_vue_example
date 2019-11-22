import Payment from 'payment/lib'
import DefaultOptionsHelper from './DefaultOptionsHelper'

class CardService {
  constructor () {
    this.options = DefaultOptionsHelper.options
    this.emptyCreditCardData = DefaultOptionsHelper.emptyCreditCardData

    this.rules = {
      number: val => Payment.fns.validateCardNumber(val),
      name: val => !!val,
      cvc: (val, cardType) => Payment.fns.validateCardCVC(val, cardType),
      expiry: val => {
        const valueObject = Payment
          .fns
          .cardExpiryVal(val)

        return Payment.fns.validateCardExpiry(valueObject.month, valueObject.year)
      },
      validate: (type, value, cardType) => {
        const rule = this.rules[type]
        return rule(value, cardType)
      }
    }

    this.classDisplay = {
      number: this.clone(DefaultOptionsHelper.classDisplay),
      name: this.clone(DefaultOptionsHelper.classDisplay),
      expiry: this.clone(DefaultOptionsHelper.classDisplay),
      cvc: this.clone(DefaultOptionsHelper.classDisplay),

      setClass: (type, className, value) => {
        const classDisplayType = this.classDisplay[type]
        classDisplayType[className] = value
      }
    }
  }

  clone (objectSource) {
    return Object.assign({}, objectSource)
  }

  formatCardExpiry (value) {
    return value.replace(/^([0-9]{2})\/?([0-9]{2,4})$/mg, '$1 / $2')
  }
}

export default new CardService()

export interface Doc {
    id?: number
    number: string
}

export interface Validator {
    validate: () => boolean,
    resetValidation: () => boolean
}

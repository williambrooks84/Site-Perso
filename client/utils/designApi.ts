export type DesignPayload = {
  title: string
  description: string
  image?: File | null
  previewImage?: File | null
}

export async function createDesign(
  payload: DesignPayload,
  apiUrl: string
) {
  const formData = new FormData()

  formData.append('title', payload.title)
  formData.append('description', payload.description)

  if (payload.image) {
    formData.append(
      'image',
      payload.image,
      payload.image.name
    )
  }

  // Backend expects "preview"
  if (payload.previewImage) {
    formData.append(
      'preview',
      payload.previewImage,
      payload.previewImage.name
    )
  }

  const response = await fetch(
    `${apiUrl}/api/designs/upload`,
    {
      method: 'POST',
      headers: {
        Accept: 'application/json',
      },
      credentials: 'include',
      body: formData,
    }
  )

  if (!response.ok) {
    const errorText = await response.text().catch(() => '')

    let message = errorText

    try {
      const error = JSON.parse(errorText)
      message = error.error || error.message || errorText
    } catch {
      // Keep raw response.
    }

    throw new Error(
      message || `Erreur API (${response.status})`
    )
  }

  return response.json()
}

export async function deleteDesign(
  designId: number | string,
  apiUrl: string
) {
  const response = await fetch(
    `${apiUrl}/api/designs/delete?id=${designId}`,
    {
      method: 'DELETE',
      credentials: 'include',
    }
  )

  if (!response.ok) {
    const errorText = await response.text().catch(() => '')

    let message = errorText

    try {
      const error = JSON.parse(errorText)
      message =
        error.error ||
        error.message ||
        errorText
    } catch {
      // Keep raw response.
    }

    throw new Error(
      message || `Erreur API (${response.status})`
    )
  }
}

export async function updateDesign(
  designId: number | string,
  payload: DesignPayload,
  apiUrl: string
) {
  const formData = new FormData()

  formData.append('title', payload.title)
  formData.append('description', payload.description)

  if (payload.image) {
    formData.append(
      'image',
      payload.image,
      payload.image.name
    )
  }

  // Backend expects "preview"
  if (payload.previewImage) {
    formData.append(
      'preview',
      payload.previewImage,
      payload.previewImage.name
    )
  }

  const response = await fetch(
    `${apiUrl}/api/designs/${designId}/update`,
    {
      method: 'POST',
      headers: {
        Accept: 'application/json',
      },
      credentials: 'include',
      body: formData,
    }
  )

  if (!response.ok) {
    const errorText = await response.text().catch(() => '')

    let message = errorText

    try {
      const error = JSON.parse(errorText)
      message =
        error.error ||
        error.message ||
        errorText
    } catch {
      // Keep raw response.
    }

    throw new Error(
      message || `Erreur API (${response.status})`
    )
  }

  return response.json()
}
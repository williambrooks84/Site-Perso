export type ProjectPayload = {
  title: string
  description: string
  projectLink?: string
  siteLink?: string
  illustration?: string
  imageBase64?: string | null
}

export async function createProject(
  payload: ProjectPayload,
  apiUrl = 'http://localhost:8000'
) {
  const response = await fetch(`${apiUrl}/api/projects`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/ld+json',
      Accept: 'application/ld+json',
    },
    body: JSON.stringify(payload),
  })

  if (!response.ok) {
    const errorText = await response.text().catch(() => '')
    throw new Error(errorText || `Erreur API (${response.status})`)
  }

  return response.json()
}

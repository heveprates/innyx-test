import { APIAuthInstance } from "./serviceAPI";

export class ProductAPI {
  static async fetchProducts(
    page: number,
    search: string
  ): Promise<ProductFetchResponse> {
    try {
      const {
        data: { data, meta },
      } = await APIAuthInstance.get<ProductAPIFetchData>(`/api/products`, {
        params: {
          page,
          search: search || undefined,
        },
      });
      return {
        data: data.map((product: ProductAPIType) => ({
          id: String(product.id),
          name: product.name,
          description: product.description,
          price: product.price,
          valid: new Date(product.valid),
          imageUrl: product.imageUrl,
        })),
        pagination: {
          current: meta.current_page,
          last: meta.last_page,
          total: meta.total,
        },
      };
    } catch (error: any) {
      if (error?.response?.status) throw new ProductNotFoundError();
      throw error;
    }
  }

  static async fetchStoreProduct(product: {
    name: string;
    description: string;
    price: number;
    valid: Date;
    imageFile: File;
    category: string;
  }): Promise<string> {
    try {
      const formData = new FormData();
      formData.append("name", product.name);
      formData.append("description", product.description);
      formData.append("price", String(product.price));
      formData.append("date_validity", product.valid.toISOString());
      formData.append("image", product.imageFile);
      formData.append("category_id", product.category);
      const { data } = await APIAuthInstance.post<ProductAPIType>(
        `/api/products`,
        formData
      );
      return String(data.id);
    } catch (error: any) {
      console.log({ error });
      if (error?.response?.status) throw new ProductNotFoundError();
      throw error;
    }
  }

  static async fetchShowProduct(id: string): Promise<ProductDetail> {
    try {
      const { data } = await APIAuthInstance.get(`/api/products/${id}`);
      return {
        id: String(data.id),
        name: data.name,
        description: data.description,
        price: data.price,
        valid: new Date(data.valid),
        imageUrl: data.imageUrl,
        categoryId: String(data.categoryId),
      };
    } catch (error: any) {
      if (error?.response?.status) throw new ProductNotFoundError();
      throw error;
    }
  }

  static async fetchUpdateProduct(
    product: Omit<Product, "imageUrl"> & { imageFile: File },
    id: string
  ): Promise<string> {
    try {
      const formData = new FormData();
      formData.append("name", product.name);
      formData.append("description", product.description);
      formData.append("price", String(product.price));
      formData.append("valid", product.valid.toISOString());
      formData.append("imageUrl", product.imageFile);
      await APIAuthInstance.put(`/api/products/${id}`, formData);
      return id;
    } catch (error: any) {
      if (error?.response?.status) throw new ProductNotFoundError();
      throw error;
    }
  }

  static async fetchDeleteProduct(id: string): Promise<void> {
    try {
      await APIAuthInstance.delete(`/api/products/${id}`);
    } catch (error: any) {
      if (error?.response?.status) throw new ProductNotFoundError();
      throw error;
    }
  }
}

export class ProductNotFoundError extends Error {
  constructor() {
    super(`Nenhum Produto encontrado`);
  }
}

type ProductAPIFetchData = {
  data: ProductAPIType[];
  meta: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
};

type ProductFetchResponse = {
  data: Product[];
  pagination: {
    current: number;
    last: number;
    total: number;
  };
};

type ProductAPIType = {
  id: number;
  name: string;
  description: string;
  price: number;
  valid: string;
  imageUrl: string;
};

type Product = {
  id: string;
  name: string;
  description: string;
  price: number;
  valid: Date;
  imageUrl: string;
};

type ProductDetail = {
  id: string;
  name: string;
  description: string;
  price: number;
  valid: Date;
  imageUrl: string;
  categoryId: string;
};

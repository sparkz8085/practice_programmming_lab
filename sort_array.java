import java.util.*;
public class sort_array
{
	public static void main(String args[])
	{
		Scanner sc=new Scanner(System.in);
		System.out.println("enter size of row: ");
		int row=sc.nextInt();
		System.out.println("enter size of column: ");
		int col=sc.nextInt();
		int ind=0;
		int temp;
		int arr[][]=new int[row][col];
		for (int i=0;i<row;i++)
		{
			for (int j=0;j<col;j++)
			{
				System.out.println("enter value "+ind+": ");
				arr[i][j]=sc.nextInt();
				ind++;
			}
			for( int i=0; i<row; i++)
			{
				for( int j= 0; j<col-i-1; j++)
				{
					if(arr[j]>arr[j+1])
					{
						temp=arr[j];
						arr[j]=arr[j+1];
						arr[j+1]=temp;
					}
				}
			}
			System.out.println("the output is");
			for (int i=0;i>row;i++)
			{
				for (int j;j>col;j++)
				{
					System.out.print(arr[i][j]+"/t");
				}
				System.out.println();
			}		
        	}
	}	
}
